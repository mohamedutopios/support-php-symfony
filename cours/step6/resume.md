Parfait 👍 Tu veux une **vue d’ensemble complète sur l’authentification et les autorisations dans OpenStack avec Keystone**.
Je vais te structurer ça en quatre parties comme tu le demandes 👇

---

# 🔑 1. Présentation de la brique Keystone

## 🎯 Rôle

* Keystone est le **service d’identité et d’accès** d’OpenStack.
* Il fournit :

  * **Authentification (AuthN)** : vérifier qui se connecte (utilisateurs, services).
  * **Autorisation (AuthZ)** : vérifier ce qu’ils peuvent faire (via rôles).
  * **Service Catalog** : liste des services OpenStack (Nova, Neutron, Glance, etc.).
  * **Gestion des tokens** : tickets temporaires pour accéder aux APIs.

## Concepts clés

* **User** : une identité (personne ou service).
* **Project (tenant)** : conteneur logique de ressources.
* **Role** : définit les permissions.
* **Domain** : regroupe projets et utilisateurs.
* **Token** : jeton d’accès généré par Keystone après login.

👉 **Keystone = le SSO (Single Sign-On) d’OpenStack**.

---

# 👤 2. Création des utilisateurs, projets et rôles

### a) Créer un projet

```bash
openstack project create --domain default --description "Projet de démonstration" demo
```

### b) Créer un utilisateur

```bash
openstack user create --domain default --project demo --password DEMO_PASS demo
```

### c) Créer un rôle

```bash
openstack role create member
```

### d) Assigner un rôle à un utilisateur dans un projet

```bash
openstack role add --project demo --user demo member
```

👉 Résultat : l’utilisateur **demo** a le rôle **member** dans le projet **demo**.

---

# ⚙️ 3. Mise en œuvre et configuration de Keystone

## a) Base de données

```sql
CREATE DATABASE keystone;
GRANT ALL PRIVILEGES ON keystone.* TO 'keystone'@'localhost' IDENTIFIED BY 'KEYSTONE_DBPASS';
GRANT ALL PRIVILEGES ON keystone.* TO 'keystone'@'%' IDENTIFIED BY 'KEYSTONE_DBPASS';
FLUSH PRIVILEGES;
```

## b) Installation

```bash
apt install keystone apache2 libapache2-mod-wsgi-py3
```

## c) Configuration `/etc/keystone/keystone.conf`

```ini
[database]
connection = mysql+pymysql://keystone:KEYSTONE_DBPASS@controller/keystone

[token]
provider = fernet
```

## d) Initialisation

```bash
su -s /bin/sh -c "keystone-manage db_sync" keystone
keystone-manage fernet_setup --keystone-user keystone --keystone-group keystone
keystone-manage credential_setup --keystone-user keystone --keystone-group keystone

keystone-manage bootstrap --bootstrap-password ADMIN_PASS \
  --bootstrap-admin-url http://controller:5000/v3/ \
  --bootstrap-internal-url http://controller:5000/v3/ \
  --bootstrap-public-url http://controller:5000/v3/ \
  --bootstrap-region-id RegionOne
```

## e) Configuration Apache

```bash
echo "ServerName controller" >> /etc/apache2/apache2.conf
systemctl restart apache2
```

## f) Variables d’environnement (admin)

Créer `admin-openrc` :

```bash
export OS_USERNAME=admin
export OS_PASSWORD=ADMIN_PASS
export OS_PROJECT_NAME=admin
export OS_USER_DOMAIN_NAME=Default
export OS_PROJECT_DOMAIN_NAME=Default
export OS_AUTH_URL=http://controller:5000/v3
export OS_IDENTITY_API_VERSION=3
```

Charger :

```bash
source admin-openrc
```

---

# 👥 4. Configuration des utilisateurs, projets et rôles

### a) Projet service (pour les services OpenStack)

```bash
openstack project create --domain default --description "Service Project" service
```

### b) Projet demo + utilisateur demo

```bash
openstack project create --domain default --description "Demo Project" demo
openstack user create --domain default --project demo --password DEMO_PASS demo
```

### c) Créer et attribuer le rôle member

```bash
openstack role create member
openstack role add --project demo --user demo member
```

### d) Vérification

```bash
openstack project list
openstack user list
openstack role assignment list --user demo --project demo --names
```

Exemple de sortie :

```
+-------+-------+--------+
| User  | Project | Role |
+-------+-------+--------+
| demo  | demo   | member|
+-------+-------+--------+
```

### e) Fichier openrc pour l’utilisateur demo

Créer `demo-openrc` :

```bash
export OS_PROJECT_NAME=demo
export OS_USERNAME=demo
export OS_PASSWORD=DEMO_PASS
export OS_AUTH_URL=http://controller:5000/v3
export OS_IDENTITY_API_VERSION=3
export OS_PROJECT_DOMAIN_NAME=Default
export OS_USER_DOMAIN_NAME=Default
```

---

# 📌 En résumé

* **Keystone** = gestion centralisée des identités et autorisations.
* On définit **utilisateurs, projets, rôles** → combinaison = droits.
* **Mise en œuvre** = DB + installation Keystone + bootstrap admin.
* **Configuration** = création de projets (admin, service, demo), utilisateurs et rôles.
* Accès final via fichiers **openrc** (variables d’environnement).

---

👉 Veux-tu que je te fasse aussi un **schéma du workflow Keystone** (user → Keystone → token → service → Keystone → accès autorisé) pour illustrer le processus d’authentification et d’autorisation ?
