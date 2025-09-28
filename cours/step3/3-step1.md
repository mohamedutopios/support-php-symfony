Très bien 👍 On passe à la **mise en œuvre et la configuration de Swift** (Object Storage) dans OpenStack.
Je vais détailler les étapes typiques sur **Ubuntu/Debian**, mais la logique est similaire sur CentOS/AlmaLinux.

---

# ⚙️ Mise en œuvre de Swift

## 1. 🔹 Prérequis

* Un cluster OpenStack déjà installé avec **Keystone** (authentification).
* **RabbitMQ** et **MariaDB** opérationnels.
* Plusieurs serveurs (ou disques) disponibles pour stocker les objets.
* Résolution DNS ou fichier `/etc/hosts` configuré (ex : `controller`, `swift-storage1`, etc.).

---

## 2. 🔹 Architecture cible

* **Controller node** :

  * Proxy Server (entrée des requêtes REST)
  * Ring builder (génère les anneaux)

* **Storage nodes** :

  * Account server
  * Container server
  * Object server
  * Stockage physique des objets (disques / partitions montées sur `/srv/node/`)

---

## 3. 🔹 Étapes d’installation

### a) Sur le **controller (proxy node)**

1. **Créer la base de données pour Swift**

   ```sql
   CREATE DATABASE swift;
   GRANT ALL PRIVILEGES ON swift.* TO 'swift'@'localhost' IDENTIFIED BY 'SWIFT_PASS';
   FLUSH PRIVILEGES;
   ```

2. **Créer l’utilisateur dans Keystone**

   ```bash
   openstack user create --domain default --password SWIFT_PASS swift
   openstack role add --project service --user swift admin
   openstack service create --name swift --description "OpenStack Object Storage" object-store
   openstack endpoint create --region RegionOne object-store public http://controller:8080/v1/AUTH_%\(project_id\)s
   openstack endpoint create --region RegionOne object-store internal http://controller:8080/v1/AUTH_%\(project_id\)s
   openstack endpoint create --region RegionOne object-store admin http://controller:8080/v1
   ```

3. **Installer les paquets Swift Proxy**

   ```bash
   apt install swift swift-proxy python3-swiftclient \
     python3-keystoneclient python3-keystonemiddleware \
     memcached
   ```

4. **Configurer `/etc/swift/proxy-server.conf`**
   Exemple minimal :

   ```ini
   [DEFAULT]
   bind_port = 8080
   user = swift
   swift_dir = /etc/swift

   [pipeline:main]
   pipeline = catch_errors gatekeeper healthcheck proxy-logging cache authtoken keystoneauth proxy-logging proxy-server

   [app:proxy-server]
   use = egg:swift#proxy
   account_autocreate = true

   [filter:keystoneauth]
   use = egg:swift#keystoneauth
   operator_roles = admin,user

   [filter:authtoken]
   paste.filter_factory = keystonemiddleware.auth_token:filter_factory
   www_authenticate_uri = http://controller:5000
   auth_url = http://controller:5000
   project_domain_name = Default
   user_domain_name = Default
   project_name = service
   username = swift
   password = SWIFT_PASS

   [filter:cache]
   use = egg:swift#memcache
   memcache_servers = controller:11211
   ```

---

### b) Sur les **storage nodes**

1. **Installer Swift et dépendances**

   ```bash
   apt install swift swift-account swift-container swift-object xfsprogs rsync
   ```

2. **Préparer les disques**
   Exemple avec `/dev/sdb` :

   ```bash
   mkfs.xfs /dev/sdb
   mkdir -p /srv/node/sdb
   echo "/dev/sdb /srv/node/sdb xfs noatime,nodiratime,nobarrier,logbufs=8 0 0" >> /etc/fstab
   mount -a
   ```

3. **Configurer rsync** (`/etc/rsyncd.conf`) :

   ```ini
   uid = swift
   gid = swift
   [account]
   path = /srv/node/
   read only = false
   [container]
   path = /srv/node/
   read only = false
   [object]
   path = /srv/node/
   read only = false
   ```

4. **Configurer Swift sur chaque service** (`/etc/swift/account-server.conf`, `/etc/swift/container-server.conf`, `/etc/swift/object-server.conf`) :
   Exemple pour object :

   ```ini
   [DEFAULT]
   devices = /srv/node
   mount_check = true
   bind_ip = 0.0.0.0
   bind_port = 6000
   user = swift
   swift_dir = /etc/swift
   ```

---

### c) Création des **rings** (depuis le controller)

* **Account ring** :

  ```bash
  swift-ring-builder account.builder create 10 3 1
  swift-ring-builder account.builder add --region 1 --zone 1 --ip 10.0.0.21 --port 6002 --device sdb --weight 100
  swift-ring-builder account.builder rebalance
  ```
* **Container ring** :

  ```bash
  swift-ring-builder container.builder create 10 3 1
  swift-ring-builder container.builder add --region 1 --zone 1 --ip 10.0.0.21 --port 6001 --device sdb --weight 100
  swift-ring-builder container.builder rebalance
  ```
* **Object ring** :

  ```bash
  swift-ring-builder object.builder create 10 3 1
  swift-ring-builder object.builder add --region 1 --zone 1 --ip 10.0.0.21 --port 6000 --device sdb --weight 100
  swift-ring-builder object.builder rebalance
  ```

👉 Les fichiers générés (`*.ring.gz`) doivent être copiés sur **tous les nœuds Swift** (`/etc/swift/`).

---

### d) Démarrer les services

* Sur le **proxy** :

  ```bash
  systemctl restart swift-proxy
  ```
* Sur les **storage nodes** :

  ```bash
  systemctl restart swift-account swift-container swift-object
  ```

---

## 4. 🔹 Vérification

* **Lister les containers (buckets)** :

  ```bash
  openstack container list
  ```
* **Créer un container** :

  ```bash
  openstack container create backups
  ```
* **Uploader un objet** :

  ```bash
  openstack object create backups /etc/hosts
  ```
* **Télécharger un objet** :

  ```bash
  openstack object save backups hosts
  ```

---

# 📌 En résumé

* **Swift proxy** : point d’entrée, configuré sur le controller.
* **Storage nodes** : stockent réellement les objets (account, container, object).
* **Rings** : déterminent la répartition des données → doivent être identiques sur tous les nœuds.
* **Keystone** : gère l’authentification des utilisateurs.

---

👉 Veux-tu que je t’élabore un **schéma visuel de déploiement Swift** (proxy + storage nodes + rings + réplication) pour que ce soit encore plus pédagogique ?
