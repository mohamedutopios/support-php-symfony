Parfait 👍 Tu veux voir la **mise en œuvre et configuration du service de routage (Neutron L3 agent)**.
Je vais détailler étape par étape comme dans un vrai déploiement OpenStack.

---

# ⚙️ Mise en œuvre et configuration du daemon de routage L3 (Neutron)

## 1. 🔹 Prérequis

* **Controller node** avec :

  * Keystone, Glance, Nova, Neutron-server déjà installés.
* **Network node** (ou sur controller si déploiement compact) :

  * Paquets neutron-l3-agent.
  * Open vSwitch ou Linux Bridge.
  * Interface connectée au **réseau externe** (ex. `eth1`).

---

## 2. 🔹 Installation du L3 agent

Sur le **network node** (ou controller si tout-en-un) :

```bash
apt install neutron-l3-agent
```

---

## 3. 🔹 Configuration du L3 agent

Éditer `/etc/neutron/l3_agent.ini` :

### Exemple avec Open vSwitch

```ini
[DEFAULT]
# Driver de l’interface
interface_driver = openvswitch

# Activer l’agent L3
external_network_bridge =

# Mode de l’agent (legacy ou dvr)
agent_mode = legacy
```

👉 Explications :

* `interface_driver` → type de switch virtuel (`openvswitch` ou `linuxbridge`).
* `external_network_bridge` → laisser vide (Neutron créera le bridge br-ex).
* `agent_mode` :

  * `legacy` = centralisé (tout le routage sur le network node).
  * `dvr` = distribué (routage et NAT sur les compute nodes).

---

## 4. 🔹 Configuration d’Open vSwitch

Sur le **network node** :

1. Vérifier OVS :

   ```bash
   ovs-vsctl show
   ```
2. Créer le bridge externe :

   ```bash
   ovs-vsctl add-br br-ex
   ovs-vsctl add-port br-ex eth1
   ```

   👉 `eth1` est l’interface connectée au réseau public/provider.

---

## 5. 🔹 Redémarrage des services

```bash
systemctl restart neutron-l3-agent
systemctl enable neutron-l3-agent
```

Vérification :

```bash
openstack network agent list
```

👉 Tu dois voir une ligne avec **L3 agent** en état `alive`.

---

## 6. 🔹 Création d’un routeur Neutron

1. **Créer un routeur** :

   ```bash
   openstack router create myrouter
   ```
2. **Attacher le routeur au réseau externe** :

   ```bash
   openstack router set myrouter --external-gateway public-net
   ```
3. **Attacher le subnet privé** :

   ```bash
   openstack router add subnet myrouter private-subnet
   ```

👉 Neutron crée un namespace Linux `qrouter-<UUID>` sur le network node.

---

## 7. 🔹 Vérification

* Lister les namespaces :

  ```bash
  ip netns
  ```

  Exemple :

  ```
  qrouter-1a2b3c4d-xxxx-xxxx
  qdhcp-xxxx
  ```
* Vérifier la configuration du routeur :

  ```bash
  ip netns exec qrouter-<UUID> ip addr
  ip netns exec qrouter-<UUID> ip route
  ```
* Vérifier la NAT :

  ```bash
  ip netns exec qrouter-<UUID> iptables -t nat -L -n -v
  ```

---

## 8. 🔹 Test de connectivité

1. Créer une instance dans `private-net`.
2. Lui attribuer une **Floating IP** :

   ```bash
   openstack floating ip create public-net
   openstack server add floating ip vm1 203.0.113.50
   ```
3. Depuis Internet, pinguer la Floating IP :

   ```bash
   ping 203.0.113.50
   ```

👉 Si tout est bien configuré, tu as connectivité externe.

---

# 📌 En résumé

* **Installer `neutron-l3-agent`** sur le network node.
* **Configurer `/etc/neutron/l3_agent.ini`** avec `openvswitch` et `agent_mode`.
* **Créer un bridge externe (`br-ex`)** relié à la carte réseau physique.
* **Créer un routeur Neutron** et connecter subnets internes ↔ réseau externe.
* Vérifier avec les **namespaces (qrouter)** et tester avec une **Floating IP**.

---

👉 Veux-tu que je complète avec un **schéma visuel montrant le rôle du L3 agent** (VM privée → routeur Neutron → br-ex → Internet), pour mieux visualiser le chemin du trafic ?
