Parfait 👍 Tu veux la **mise en œuvre de la gestion des utilisateurs, projets et rôles avec Keystone**.
C’est un point central car Keystone est la **brique identité** d’OpenStack.

---

# ⚙️ Gestion des utilisateurs, projets et rôles dans Keystone

## 1. 🔹 Concepts de base

* **User (utilisateur)** → représente une personne ou un service.
* **Project (projet / tenant)** → espace logique qui regroupe des ressources (VM, volumes, réseaux).
* **Role (rôle)** → définit les permissions d’un utilisateur sur un projet.

👉 Un **user + project + role = une autorisation effective**.

---

## 2. 🔹 Préparation de l’environnement

Avant de manipuler Keystone, tu dois avoir chargé les variables d’admin :

```bash
source admin-openrc
```

---

## 3. 🔹 Création d’un projet

Créer un projet nommé **demo** :

```bash
openstack project create --domain default --description "Projet de démonstration" demo
```

Vérifier :

```bash
openstack project list
```

---

## 4. 🔹 Création d’un utilisateur

Créer un utilisateur **alice** associé au projet **demo** :

```bash
openstack user create --domain default --project demo --password ALICE_PASS alice
```

👉 Ici `ALICE_PASS` est le mot de passe de l’utilisateur.

Vérifier :

```bash
openstack user list
```

---

## 5. 🔹 Création d’un rôle

Créer un rôle personnalisé **developer** :

```bash
openstack role create developer
```

Lister les rôles existants :

```bash
openstack role list
```

---

## 6. 🔹 Attribution d’un rôle à un utilisateur dans un projet

Donner le rôle **developer** à **alice** dans le projet **demo** :

```bash
openstack role add --project demo --user alice developer
```

👉 Un utilisateur peut avoir plusieurs rôles dans un même projet, ou différents rôles dans différents projets.

---

## 7. 🔹 Vérification

Lister les rôles attribués :

```bash
openstack role assignment list --user alice --project demo --names
```

Exemple de sortie :

```
+-------------+----------+----------+
| User        | Project  | Role     |
+-------------+----------+----------+
| alice       | demo     | developer|
+-------------+----------+----------+
```

---

## 8. 🔹 Exemple d’utilisation par Alice

Alice peut charger un fichier `demo-openrc` avec ses identifiants :

```bash
export OS_PROJECT_NAME=demo
export OS_USERNAME=alice
export OS_PASSWORD=ALICE_PASS
export OS_AUTH_URL=http://controller:5000/v3
export OS_IDENTITY_API_VERSION=3
export OS_PROJECT_DOMAIN_NAME=Default
export OS_USER_DOMAIN_NAME=Default
```

Puis vérifier son accès :

```bash
openstack token issue
```

---

# 📌 En résumé

* **Projet (tenant)** → espace de ressources.
* **Utilisateur** → identité qui s’authentifie.
* **Rôle** → ensemble de permissions.
* On attribue **un rôle à un utilisateur dans un projet** pour définir ses droits.
* Exemple concret :

  * Projet **demo**
  * Utilisateur **alice**
  * Rôle **developer**
  * Résultat : Alice a les droits de developer dans demo.

---

👉 Veux-tu que je complète avec un **tableau de rôles standards d’OpenStack (admin, member, reader, etc.)** et leurs permissions typiques pour que tu voies clairement la différence ?
