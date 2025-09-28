Voici un **cours détaillé** pour l’introduction à OpenStack, à utiliser en formation :
Avec historique, philosophie, cas d’usage, et panorama de l’écosystème.

---

# **Introduction à OpenStack**

---

## **1. Historique & philosophie du projet**

### **Historique**

* **2010** : OpenStack est créé par la collaboration entre **NASA** (projet Nebula) et **Rackspace** (cloud public américain).
* But initial : construire une **infrastructure cloud open source**, alternative aux offres propriétaires (Amazon AWS, VMware…).
* **Projet communautaire** : Rapidement adopté par de nombreux acteurs (RedHat, IBM, HP, SUSE, Intel, Canonical, etc.).
* Évolution :

  * 2011 : Premier « release » officiel (Austin)
  * Sorties régulières tous les 6 mois (cycle de développement proche de Linux)
  * Fondation OpenStack créée en 2012 pour structurer la gouvernance et la roadmap.

### **Philosophie du projet**

* **Open Source** : Tout le code est libre (licence Apache 2.0).
* **Communauté** : Contributions ouvertes, processus démocratique, évènements réguliers (OpenStack Summit, PTG…).
* **Modulaire** :

  * Chaque composant est indépendant (Compute, Réseau, Stockage…).
  * Les services communiquent via API REST et message bus (RabbitMQ).
* **Interopérable** :

  * API standardisées, support multi-hyperviseur (KVM, Xen, VMware…)
  * Support de multiples matériels réseau/stockage
* **Scalable** : Conçu pour de très grands datacenters, mais aussi utilisable en démo sur une seule machine.

---

## **2. Cas d’usage d’OpenStack**

### **Cloud privé (Private Cloud)**

* Utilisation principale : fournir à une entreprise ou un organisme son propre « cloud » à la AWS mais hébergé sur son infrastructure.
* Avantages : sécurité, maîtrise des données, personnalisation, conformité.

### **Cloud public / communautaire**

* Certains fournisseurs proposent du cloud public basé sur OpenStack (OVH Public Cloud, CityCloud, etc.)
* Offre mutualisée et élastique pour les clients, alternative aux géants du cloud (AWS, Azure).

### **Cloud hybride**

* Intégration d’OpenStack avec d’autres clouds (Azure, AWS, Google Cloud)
* Cas : migration, burst temporaire de charge, reprise d’activité.

### **Cas d’usage avancés**

* Hébergement d’environnements de test, de production, de CI/CD pour les DevOps
* Plateformes d’hébergement de VM pour la recherche (universités, laboratoires)
* Fourniture de services managés pour des clients internes (as a Service : IaaS, PaaS, CaaS)
* Support de conteneurs (Kubernetes avec Magnum, ou OpenShift sur OpenStack)
* Big Data, HPC (calcul intensif)

### **Alternatives**

* Proxmox, VMware vCloud, Apache CloudStack, Eucalyptus, Nutanix…
* Les hyperscalers : AWS, Azure, Google Cloud, mais solutions fermées.

---

## **3. Écosystème OpenStack**

### **Distributions OpenStack**

* Plusieurs acteurs proposent des distributions « clé en main » d’OpenStack :

  * **Red Hat OpenStack Platform** (RHOSP)
  * **Mirantis OpenStack**
  * **Canonical Charmed OpenStack**
  * **SUSE OpenStack Cloud** (fin de support)
  * **OVH Public Cloud**, CityCloud, etc. (services gérés)
* **Installations simplifiées** :

  * **DevStack** (pour les labs/démo, non production)
  * **MicroStack** (Canonical, facile en local)
  * **Packstack**, **TripleO**, **Kolla-Ansible** (pour la prod)

### **Projets dérivés et modules complémentaires**

* **Projets « Core »** : Keystone (identité), Nova (compute), Glance (images), Neutron (réseau), Cinder (block storage), Swift (object storage), Horizon (dashboard web)
* **Projets additionnels :**

  * **Heat** (orchestration IaaS « Infrastructure as Code »)
  * **Magnum** (Kubernetes as a Service)
  * **Ironic** (bare metal provisioning)
  * **Octavia** (Load Balancer as a Service)
  * **Barbican** (gestion des secrets)
  * **Manila** (partage de fichiers)

### **Intégrations et écosystème**

* Support de :

  * **Hyperviseurs** : KVM (par défaut), QEMU, Xen, Hyper-V, VMware ESXi
  * **Stockage** : Ceph, NetApp, EMC, local, S3 compatible
  * **Réseaux** : Cisco, Juniper, Mellanox, Open vSwitch, LinuxBridge
* Intégration possible avec :

  * **Ansible**, **Terraform**, **Kubernetes**, **Prometheus**, **Grafana**, etc.
  * Outils de supervision et monitoring (Zabbix, ELK…)

---

### **Synthèse visuelle à projeter**

```text
      +-------------------+
      |   OpenStack Core  |
      +-------------------+
     /     |     |     |    \
 Nova   Neutron  Glance  Swift  ...
  VM      Net     Img    Obj
 Compute  Work   Store  Store

   ↓ Modules additionnels (Heat, Magnum...)
   ↓ Intégrations (Ansible, K8s, Ceph...)
```

---

### **À retenir**

* OpenStack = Cloud libre, modulaire, très riche, multi-usage.
* Pilier de l’IaaS et de l’innovation Cloud en entreprise.
* Apprécié pour : maîtrise des coûts, personnalisation, communauté très active.

---

**Veux-tu des slides à projeter, une fiche mémo, ou un quiz pour animer cette intro ?**
