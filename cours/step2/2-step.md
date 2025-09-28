Très bonne question 👍 La brique **Nova** est le **cœur du calcul (Compute)** dans OpenStack. Je vais te présenter d’abord son rôle et son architecture, puis ses étapes de mise en œuvre et configuration.

---

# 🔹 Présentation de Nova

## 1. Rôle

* **Nova** est le **service de gestion du calcul** dans OpenStack.
* Il orchestre et pilote :

  * Le **lancement des machines virtuelles (VMs)** sur les hyperviseurs (KVM, QEMU, VMware, Hyper-V…).
  * L’**allocation des ressources** (CPU, RAM, disque).
  * La **planification (scheduling)** des instances sur les nœuds de calcul.
  * L’**interaction avec Neutron** (réseau), **Cinder** (stockage bloc) et **Glance** (images).

## 2. Architecture interne

Nova est composé de plusieurs **services** interconnectés via **RabbitMQ** et **API REST** :

* **nova-api** → Reçoit les requêtes des utilisateurs (REST).
* **nova-scheduler** → Choisit le nœud de calcul où déployer la VM.
* **nova-compute** → Déploie la VM sur l’hyperviseur (ex. KVM via libvirt).
* **nova-conductor** → Fait l’intermédiaire entre DB et compute nodes.
* **nova-consoleauth / nova-novncproxy** → Gestion de la console distante (VNC, SPICE).
* **nova-placement** → Service qui gère les ressources disponibles (inventaire CPU/RAM/disk).
* **Base de données (MariaDB/MySQL)** → Stocke l’état des instances et configurations.

---

# 🔹 Mise en œuvre de Nova

## 1. Prérequis

* **Services de base déjà installés** :

  * Keystone (identité)
  * Glance (images)
  * Neutron (réseau)
  * RabbitMQ (messagerie)
  * MariaDB/MySQL (base de données)

* **Réseau** configuré (management, provider, tenant).

* **Hyperviseur** : souvent **KVM/QEMU** sur Linux.

---

## 2. Étapes d’installation (exemple sur Ubuntu/Debian)

### 🔸 Sur le **contrôleur**

1. **Créer la base de données Nova**

   ```sql
   CREATE DATABASE nova_api;
   CREATE DATABASE nova;
   GRANT ALL PRIVILEGES ON nova_api.* TO 'nova'@'localhost' IDENTIFIED BY 'NOVA_PASS';
   GRANT ALL PRIVILEGES ON nova.* TO 'nova'@'localhost' IDENTIFIED BY 'NOVA_PASS';
   FLUSH PRIVILEGES;
   ```

2. **Créer l’utilisateur Nova dans Keystone**

   ```bash
   openstack user create --domain default --password NOVA_PASS nova
   openstack role add --project service --user nova admin
   openstack service create --name nova --description "OpenStack Compute" compute
   ```

3. **Déclarer les endpoints API (public, internal, admin)**

   ```bash
   openstack endpoint create --region RegionOne compute public http://controller:8774/v2.1
   openstack endpoint create --region RegionOne compute internal http://controller:8774/v2.1
   openstack endpoint create --region RegionOne compute admin http://controller:8774/v2.1
   ```

4. **Installer les paquets Nova**

   ```bash
   apt install nova-api nova-conductor nova-novncproxy nova-scheduler
   ```

5. **Configurer Nova (`/etc/nova/nova.conf`)**
   Exemple (partie importante) :

   ```ini
   [api_database]
   connection = mysql+pymysql://nova:NOVA_PASS@controller/nova_api

   [database]
   connection = mysql+pymysql://nova:NOVA_PASS@controller/nova

   [DEFAULT]
   transport_url = rabbit://openstack:RABBIT_PASS@controller
   auth_strategy = keystone
   my_ip = 10.0.0.11   # IP du contrôleur

   [keystone_authtoken]
   www_authenticate_uri = http://controller:5000
   auth_url = http://controller:5000
   memcached_servers = controller:11211
   auth_type = password
   project_domain_name = Default
   user_domain_name = Default
   project_name = service
   username = nova
   password = NOVA_PASS
   ```

6. **Synchroniser la DB**

   ```bash
   su -s /bin/sh -c "nova-manage api_db sync" nova
   su -s /bin/sh -c "nova-manage db sync" nova
   ```

7. **Démarrer les services**

   ```bash
   systemctl restart nova-api nova-scheduler nova-conductor nova-novncproxy
   ```

---

### 🔸 Sur le **nœud de calcul**

1. **Installer les paquets**

   ```bash
   apt install nova-compute
   ```

2. **Configurer `/etc/nova/nova.conf`**
   Exemple :

   ```ini
   [DEFAULT]
   transport_url = rabbit://openstack:RABBIT_PASS@controller
   auth_strategy = keystone
   my_ip = 10.0.0.31   # IP du compute node

   [keystone_authtoken]
   auth_url = http://controller:5000
   memcached_servers = controller:11211
   username = nova
   password = NOVA_PASS

   [libvirt]
   virt_type = kvm
   ```

3. **Redémarrer le service**

   ```bash
   systemctl restart nova-compute
   ```

---

## 3. Vérification

* Lister les services Nova :

  ```bash
  openstack compute service list
  ```
* Lancer une instance :

  ```bash
  openstack server create --flavor m1.small --image cirros \
    --nic net-id=NETWORK_ID --security-group default --key-name mykey demo-instance
  ```

---

# 📌 En résumé

* **Nova = le cerveau du compute** (machines virtuelles dans OpenStack).
* **Architecture distribuée** : API, scheduler, conductor, compute, placement.
* **Mise en œuvre** : nécessite Keystone (auth), Glance (images), Neutron (réseau).
* **Configuration clé** : `nova.conf` (DB, RabbitMQ, Keystone, IPs).

---

👉 Veux-tu que je t’ajoute un **schéma visuel d’architecture Nova** (interaction entre ses services et les autres briques OpenStack) pour l’utiliser en support de formation ?
