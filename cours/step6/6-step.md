Très bonne question 👍 Tu veux une **présentation claire de la brique Keystone**, le service d’identité d’OpenStack. Voici un tour d’horizon complet 👇

---

# 🔑 OpenStack Keystone – Vue d’ensemble

## 1. 🎯 Rôle

* **Keystone** est la **brique d’identité et d’authentification** d’OpenStack.
* Il fournit :

  * **Authentification (AuthN)** → vérifier qui se connecte (utilisateurs, services).
  * **Autorisation (AuthZ)** → vérifier ce qu’ils peuvent faire (rôles, permissions).
  * **Catalogue de services** → liste des services disponibles (Nova, Neutron, Glance, Cinder…).
  * **Token de sécurité** → système de tickets pour accéder aux API OpenStack.

👉 Sans Keystone, impossible de sécuriser et centraliser l’accès aux autres briques.

---

## 2. 🔹 Concepts clés

* **Users (utilisateurs)** → comptes qui s’authentifient.
* **Projects (projets/tenants)** → regroupements logiques (équivalent à un client, une équipe, ou une application).
* **Domains** → regroupent des projets et utilisateurs (permettent multi-entreprises).
* **Roles** → définissent les droits d’un utilisateur dans un projet.

  * Exemple : *admin*, *member*, *reader*.
* **Tokens** → générés après login, utilisés pour accéder aux services.
* **Service Catalog** → liste des endpoints (URLs) de chaque service OpenStack.

---

## 3. 🔹 Fonctionnement

1. Un utilisateur envoie ses **identifiants** (user + password, ou clé API) à Keystone.
2. Keystone vérifie et renvoie un **token d’authentification**.
3. L’utilisateur envoie ce token à un autre service (ex : Nova).
4. Nova vérifie le token auprès de Keystone avant d’autoriser l’action.
5. Keystone fournit aussi le **catalogue des services** pour que le client sache où appeler les API.

👉 Le modèle est proche d’un **SSO (Single Sign-On)** pour tout le cloud.

---

## 4. 🔹 Services Keystone

* **Identity service** : gestion des utilisateurs, projets, rôles.
* **Token service** : génération et validation des tokens (par défaut UUID ou Fernet).
* **Catalog service** : liste des endpoints pour chaque service.
* **Policy service** : règles d’accès (souvent JSON/YAML).

---

## 5. 🔹 Types de tokens

* **UUID** → ancien format, identifiant unique stocké en base.
* **Fernet** (par défaut aujourd’hui) → léger, signé cryptographiquement, ne nécessite pas de stockage DB.
* **PKI / PKIZ** → jetons signés avec certificats (deprecated).

---

## 6. 🔹 Exemple d’utilisation (CLI)

* **S’authentifier** et obtenir un token :

  ```bash
  openstack token issue
  ```

  Résultat : un token valable pour quelques heures.

* **Lister les projets** :

  ```bash
  openstack project list
  ```

* **Lister les utilisateurs** :

  ```bash
  openstack user list
  ```

* **Lister les services** :

  ```bash
  openstack service list
  ```

---

## 7. 🔹 Cas d’usage

* **Multi-tenant** : une entreprise peut héberger plusieurs clients isolés (projets différents).
* **Sécurité** : gestion centralisée des comptes et droits.
* **Interopérabilité** : permet d’intégrer OpenStack avec LDAP/AD, SAML, OpenID Connect.
* **Catalogue des services** : fournit les endpoints pour automatiser les appels API.

---

# 📌 En résumé

* **Keystone = service d’identité et d’autorisation d’OpenStack**.
* Gère : **utilisateurs, projets, rôles, tokens, catalogue de services**.
* Fonctionne comme un **SSO** pour toutes les autres briques (Nova, Neutron, Cinder, etc.).
* Supporte plusieurs **backends d’authentification** (DB interne, LDAP, AD, SAML…).

---

👉 Veux-tu que je te montre aussi la **mise en œuvre et configuration de Keystone** (création DB, utilisateur admin, endpoints, configuration `keystone.conf`) comme je l’ai fait pour Glance ?
