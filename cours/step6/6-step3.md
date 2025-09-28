Parfait 👍 Tu veux la **configuration pratique des utilisateurs, projets et rôles dans Keystone**.
Voici les étapes détaillées comme dans un vrai déploiement OpenStack 👇

---

# ⚙️ Configuration des utilisateurs, projets et rôles dans Keystone

## 1. 🔹 Charger les variables d’admin

Avant toute commande, on charge le fichier d’admin :

```bash
source admin-openrc
```

👉 Cela permet d’agir avec les privilèges admin créés lors du bootstrap de Keystone.

---

## 2. 🔹 Création d’un projet

Un projet (tenant) regroupe des ressources (VM, volumes, réseaux).

Exemple : projet **demo**

```bash
openstack project create --domain default --description "Projet de démonstration" demo
```

Vérifier :

```bash
openstack project list
```

---

## 3. 🔹 Création d’un utilisateur

Chaque utilisateur doit appartenir à un projet.

Exemple : utilisateur **alice** rattaché au projet **demo**

```bash
openstack user create --domain default --project demo --password ALICE_PASS alice
```

Vérifier :

```bash
openstack user list
```

---

## 4. 🔹 Création d’un rôle

Les rôles définissent **les permissions**. OpenStack inclut généralement `admin`, `member`, `reader`.
On peut créer des rôles personnalisés.

Exemple : rôle **developer**

```bash
openstack role create developer
```

Vérifier :

```bash
openstack role list
```

---

## 5. 🔹 Attribution d’un rôle à un utilisateur

Associer un utilisateur à un rôle dans un projet.

Exemple : donner le rôle **developer** à **alice** dans **demo** :

```bash
openstack role add --project demo --user alice developer
```

👉 La combinaison **(user + project + role)** détermine les droits effectifs.

---

## 6. 🔹 Vérification

Lister les attributions :

```bash
openstack role assignment list --user alice --project demo --names
```

Exemple de sortie :

```
+-------------+----------+-----------+
| User        | Project  | Role      |
+-------------+----------+-----------+
| alice       | demo     | developer |
+-------------+----------+-----------+
```

---

## 7. 🔹 Exemple de fichiers openrc pour l’utilisateur

Pour permettre à **alice** de se connecter, on crée un fichier `demo-openrc` :

```bash
export OS_PROJECT_NAME=demo
export OS_USERNAME=alice
export OS_PASSWORD=ALICE_PASS
export OS_AUTH_URL=http://controller:5000/v3
export OS_IDENTITY_API_VERSION=3
export OS_PROJECT_DOMAIN_NAME=Default
export OS_USER_DOMAIN_NAME=Default
```

L’utilisateur charge ses variables :

```bash
source demo-openrc
openstack token issue
```

👉 Si tout est correct, Keystone renvoie un **token valide** pour alice.

---

# 📌 En résumé

* **Projet (tenant)** = conteneur de ressources.
* **Utilisateur** = identité qui s’authentifie.
* **Rôle** = définit les permissions.
* La combinaison **user + project + role** donne les autorisations.
* Exemple :

  * Projet = **demo**
  * Utilisateur = **alice**
  * Rôle = **developer**
    → Alice peut déployer des ressources dans le projet demo.

---

👉 Veux-tu que je te prépare un **tableau des rôles standards (admin, member, reader)** avec leurs permissions typiques, pour bien visualiser qui a droit à quoi ?
