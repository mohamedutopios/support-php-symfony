Parfait 👍 Tu veux une présentation claire de la **brique Glance**, qui gère les images dans OpenStack.

---

# 🖼️ OpenStack Glance – Gestion des images

## 1. 🎯 Rôle de Glance

* **Glance** est le service OpenStack chargé de la **gestion des images disque** (modèles de VM).
* Il fournit une **API REST** pour :

  * Stocker, retrouver et distribuer des images.
  * Servir de source pour **Nova (Compute)** lorsqu’une instance est créée.
  * Être backend pour **Cinder (snapshots)** ou **Swift (stockage objet)**.

👉 Sans Glance, Nova ne saurait pas d’où prendre les systèmes d’exploitation pour créer les instances.

---

## 2. 🔹 Fonctionnalités principales

* **Gestion des images OS** (Ubuntu, CentOS, Windows, etc.).
* **Support de plusieurs formats** : QCOW2, RAW, VMDK, VHD, ISO.
* **Métadonnées** : chaque image contient des infos (taille min RAM, architecture CPU, OS type, etc.).
* **Snapshots** : possibilité de capturer l’état d’une VM et de l’enregistrer comme image réutilisable.
* **Partage** : images privées (par projet) ou publiques (pour tous).
* **Backends multiples** :

  * Swift (Object Storage)
  * Cinder (Block Storage)
  * Filesystem (local)
  * Ceph RBD

---

## 3. 🔹 Architecture de Glance

Glance est composé de plusieurs services :

* **glance-api** → reçoit les requêtes des utilisateurs (upload, download, list).
* **glance-registry** *(déprécié)* → stockait les métadonnées (intégré dans API désormais).
* **Base de données** → enregistre les métadonnées des images (nom, format, taille, propriétaire).
* **Backend de stockage** → stocke réellement les fichiers (Swift, Ceph, LVM, FS).

---

## 4. 🔹 Exemple de cycle de vie d’une image

1. L’administrateur **importe une image** (ex : Ubuntu-22.04.qcow2) dans Glance.
2. Glance **stocke le fichier** dans un backend (ex : Swift).
3. L’utilisateur demande à Nova de **lancer une VM** avec cette image.
4. Nova récupère l’image auprès de Glance → la déploie sur l’hyperviseur.
5. L’utilisateur peut faire un **snapshot de la VM** → enregistré comme nouvelle image dans Glance.

---

## 5. 🔹 Commandes principales (CLI)

* **Lister les images disponibles**

  ```bash
  openstack image list
  ```
* **Créer une nouvelle image**

  ```bash
  openstack image create "Ubuntu-22.04" \
    --file ubuntu-22.04.qcow2 \
    --disk-format qcow2 \
    --container-format bare \
    --public
  ```
* **Montrer les détails d’une image**

  ```bash
  openstack image show Ubuntu-22.04
  ```
* **Supprimer une image**

  ```bash
  openstack image delete Ubuntu-22.04
  ```

---

## 6. 🔹 Cas d’usage

* **Catalogue d’OS validés** pour les projets (ex : Ubuntu, CentOS, Windows Server).
* **Snapshots utilisateurs** pour sauvegarder ou cloner une VM.
* **Golden images** préinstallées avec logiciels d’entreprise (middleware, DB, outils de dev).
* **CI/CD** : préparation d’images customisées pour automatiser les déploiements.

---

# 📌 En résumé

* **Glance = brique de gestion des images dans OpenStack**.
* Stocke, catalogue et distribue les images pour Nova, Cinder, Swift.
* Supporte plusieurs **formats** et **backends** (Swift, Ceph, FS, Cinder).
* Gère **images OS, snapshots et golden images**.

---

👉 Veux-tu que je t’ajoute un **schéma visuel montrant le rôle de Glance** dans le workflow (Glance ⇄ Nova ⇄ Cinder/Swift) pour que tu voies bien comment ça s’intègre ?
