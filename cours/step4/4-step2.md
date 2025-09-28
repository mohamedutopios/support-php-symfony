Super 👍 tu veux voir la **création de la base de données et la mise en œuvre/configuration de Glance** (service de gestion des images).
Je vais détailler les **étapes complètes** comme pour un vrai déploiement OpenStack.

---

# ⚙️ Mise en œuvre et configuration de Glance

## 1. 🔹 Création de la base de données Glance

Sur le **Controller Node** (où MariaDB/MySQL est installé) :

```sql
CREATE DATABASE glance;
GRANT ALL PRIVILEGES ON glance.* TO 'glance'@'localhost' IDENTIFIED BY 'GLANCE_PASS';
GRANT ALL PRIVILEGES ON glance.* TO 'glance'@'%' IDENTIFIED BY 'GLANCE_PASS';
FLUSH PRIVILEGES;
```

👉 Ici `GLANCE_PASS` est un mot de passe fort à définir.
Cette base stockera les **métadonnées des images** (nom, taille, format, propriétaire…).

---

## 2. 🔹 Création de l’utilisateur et du service dans Keystone

Toujours sur le **Controller** :

```bash
# Créer l’utilisateur glance
openstack user create --domain default --password GLANCE_PASS glance

# Lui donner les droits admin sur le projet "service"
openstack role add --project service --user glance admin

# Créer le service Glance
openstack service create --name glance --description "OpenStack Image" image

# Créer les endpoints (public, internal, admin)
openstack endpoint create --region RegionOne image public   http://controller:9292
openstack endpoint create --region RegionOne image internal http://controller:9292
openstack endpoint create --region RegionOne image admin    http://controller:9292
```

---

## 3. 🔹 Installation des paquets

Sur le **Controller node** :

```bash
apt install glance
```

---

## 4. 🔹 Configuration de Glance

Éditer `/etc/glance/glance-api.conf` :

```ini
[database]
connection = mysql+pymysql://glance:GLANCE_PASS@controller/glance

[keystone_authtoken]
www_authenticate_uri = http://controller:5000
auth_url = http://controller:5000
memcached_servers = controller:11211
auth_type = password
project_domain_name = Default
user_domain_name = Default
project_name = service
username = glance
password = GLANCE_PASS

[paste_deploy]
flavor = keystone

[glance_store]
stores = file,http
default_store = file
filesystem_store_datadir = /var/lib/glance/images/
```

👉 Ici :

* **backend = filesystem** (par défaut : les images sont stockées localement dans `/var/lib/glance/images/`).
* On pourrait aussi configurer Swift, Ceph, Cinder comme backend.

---

## 5. 🔹 Synchronisation de la base de données

```bash
su -s /bin/sh -c "glance-manage db_sync" glance
```

---

## 6. 🔹 Démarrage et activation des services

```bash
systemctl restart glance-api
systemctl enable glance-api
```

---

## 7. 🔹 Vérification

* **Lister les images** (doit être vide au début) :

  ```bash
  openstack image list
  ```

* **Ajouter une image (ex : Cirros, petite image de test)** :

  ```bash
  wget http://download.cirros-cloud.net/0.5.2/cirros-0.5.2-x86_64-disk.img

  openstack image create "cirros" \
    --file cirros-0.5.2-x86_64-disk.img \
    --disk-format qcow2 \
    --container-format bare \
    --public
  ```

* **Vérifier** :

  ```bash
  openstack image list
  ```

👉 Tu dois voir :

```
+--------------------------------------+--------+--------+
| ID                                   | Name   | Status |
+--------------------------------------+--------+--------+
| 1234abcd-...                         | cirros | active |
+--------------------------------------+--------+--------+
```

---

# 📌 En résumé

1. **Créer la DB MySQL/MariaDB** pour Glance.
2. **Créer l’utilisateur/service** dans Keystone + endpoints.
3. **Installer Glance** et configurer `glance-api.conf`.
4. **Choisir un backend de stockage** (filesystem, Swift, Ceph, etc.).
5. **Synchroniser la DB** et démarrer le service.
6. **Vérifier avec une image de test** (Cirros).

---

👉 Veux-tu que je complète avec la **configuration de Glance pour un backend Ceph RBD** (plus réaliste en production que filesystem), ou tu préfères rester sur la configuration simple en **filesystem** pour un lab ?
