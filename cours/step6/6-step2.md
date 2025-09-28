Parfait 👍 Tu veux la **mise en œuvre et configuration de Keystone** (gestion des utilisateurs, projets et rôles) comme dans un vrai déploiement OpenStack. Voici les étapes complètes 👇

---

# ⚙️ Mise en œuvre et configuration de Keystone

## 1. 🔹 Création de la base de données

Sur le **Controller Node** (MariaDB/MySQL) :

```sql
CREATE DATABASE keystone;
GRANT ALL PRIVILEGES ON keystone.* TO 'keystone'@'localhost' IDENTIFIED BY 'KEYSTONE_DBPASS';
GRANT ALL PRIVILEGES ON keystone.* TO 'keystone'@'%' IDENTIFIED BY 'KEYSTONE_DBPASS';
FLUSH PRIVILEGES;
```

👉 Ici `KEYSTONE_DBPASS` = mot de passe de la base de données Keystone.

---

## 2. 🔹 Installation et configuration

Installer Keystone et ses dépendances (sur le controller) :

```bash
apt install keystone apache2 libapache2-mod-wsgi-py3
```

Configurer `/etc/keystone/keystone.conf` :

```ini
[database]
connection = mysql+pymysql://keystone:KEYSTONE_DBPASS@controller/keystone

[token]
provider = fernet
```

Initialiser la base :

```bash
su -s /bin/sh -c "keystone-manage db_sync" keystone
```

---

## 3. 🔹 Mise en place des tokens et certificats

Configurer les clés Fernet et credentials :

```bash
keystone-manage fernet_setup --keystone-user keystone --keystone-group keystone
keystone-manage credential_setup --keystone-user keystone --keystone-group keystone
```

Configurer le bootstrap de Keystone (admin initial) :

```bash
keystone-manage bootstrap --bootstrap-password ADMIN_PASS \
  --bootstrap-admin-url http://controller:5000/v3/ \
  --bootstrap-internal-url http://controller:5000/v3/ \
  --bootstrap-public-url http://controller:5000/v3/ \
  --bootstrap-region-id RegionOne
```

👉 Ici `ADMIN_PASS` est le mot de passe admin d’OpenStack.

---

## 4. 🔹 Configuration Apache

Keystone s’exécute sous Apache :

Éditer `/etc/apache2/apache2.conf` pour ajouter :

```apache
ServerName controller
```

Puis :

```bash
systemctl restart apache2
systemctl enable apache2
```

---

## 5. 🔹 Variables d’environnement (admin)

Créer un fichier `admin-openrc` :

```bash
export OS_USERNAME=admin
export OS_PASSWORD=ADMIN_PASS
export OS_PROJECT_NAME=admin
export OS_USER_DOMAIN_NAME=Default
export OS_PROJECT_DOMAIN_NAME=Default
export OS_AUTH_URL=http://controller:5000/v3
export OS_IDENTITY_API_VERSION=3
```

Charger les variables :

```bash
source admin-openrc
```

---

## 6. 🔹 Création des projets, utilisateurs et rôles

### a) Projet de service

```bash
openstack project create --domain default --description "Service Project" service
```

### b) Projet de démo

```bash
openstack project create --domain default --description "Demo Project" demo
```

### c) Utilisateur demo

```bash
openstack user create --domain default --password DEMO_PASS demo
```

### d) Rôle member

```bash
openstack role create member
```

### e) Associer rôle à l’utilisateur

```bash
openstack role add --project demo --user demo member
```

---

## 7. 🔹 Vérification

* Lister les projets :

  ```bash
  openstack project list
  ```
* Lister les utilisateurs :

  ```bash
  openstack user list
  ```
* Vérifier le rôle attribué :

  ```bash
  openstack role assignment list --user demo --project demo --names
  ```

---

# 📌 En résumé

1. Créer la **base Keystone**.
2. Installer et configurer **keystone + Apache**.
3. Initialiser DB + clés Fernet + bootstrap admin.
4. Définir le **projet service** (pour les services OpenStack).
5. Créer **projets, utilisateurs, rôles** pour les tenants.
6. Vérifier avec `openstack token issue` et `openstack user list`.

---

👉 Veux-tu que je complète avec un **schéma du workflow Keystone** (user → Keystone → token → service → Keystone → accès) pour visualiser comment un utilisateur s’authentifie et obtient un accès aux autres briques ?
