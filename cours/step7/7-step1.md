Super 👍 Tu veux comprendre comment fonctionne **l’automatisation avec l’API REST dans OpenStack**.
Toutes les briques (Nova, Neutron, Glance, Cinder, Keystone, etc.) exposent une **API RESTful** qui permet d’automatiser la gestion du cloud sans passer par Horizon ou la CLI.

---

# 🌐 Automatisation avec l’API REST OpenStack

## 1. 🎯 Principe

* Chaque service OpenStack expose une **API REST** (HTTP/HTTPS).
* Les clients (CLI, SDK, Horizon, ou scripts) **consomment ces APIs**.
* L’authentification se fait via **Keystone** → obtention d’un **token**.
* Les appels sont faits en **JSON sur HTTP**, comme n’importe quelle API REST.

👉 Cela permet d’intégrer OpenStack dans des outils d’automatisation (Ansible, Terraform, scripts Python, CI/CD).

---

## 2. 🔹 Étapes d’utilisation de l’API REST

### a) Authentification (Keystone v3)

Obtenir un token :

```bash
curl -i -X POST http://controller:5000/v3/auth/tokens \
  -H "Content-Type: application/json" \
  -d '{
        "auth": {
          "identity": {
            "methods": ["password"],
            "password": {
              "user": {
                "name": "admin",
                "domain": { "id": "default" },
                "password": "ADMIN_PASS"
              }
            }
          },
          "scope": {
            "project": {
              "name": "admin",
              "domain": { "id": "default" }
            }
          }
        }
      }'
```

👉 La réponse contient un header `X-Subject-Token` qui est ton **token d’accès**.

---

### b) Consommer les APIs avec le token

#### Exemple : lister les images (Glance)

```bash
curl -s -X GET http://controller:9292/v2/images \
  -H "X-Auth-Token: $TOKEN"
```

#### Exemple : créer une VM (Nova)

```bash
curl -s -X POST http://controller:8774/v2.1/servers \
  -H "Content-Type: application/json" \
  -H "X-Auth-Token: $TOKEN" \
  -d '{
        "server": {
          "name": "demo-vm",
          "imageRef": "IMAGE_ID",
          "flavorRef": "FLAVOR_ID",
          "networks": [{"uuid": "NETWORK_ID"}]
        }
      }'
```

#### Exemple : créer un réseau (Neutron)

```bash
curl -s -X POST http://controller:9696/v2.0/networks \
  -H "Content-Type: application/json" \
  -H "X-Auth-Token: $TOKEN" \
  -d '{
        "network": {
          "name": "private-net",
          "admin_state_up": true
        }
      }'
```

---

## 3. 🔹 SDK et outils d’automatisation

* **SDK Python (openstacksdk)** → simplifie l’utilisation de l’API.

  ```python
  from openstack import connection

  conn = connection.Connection(
      auth_url="http://controller:5000/v3",
      project_name="demo",
      username="alice",
      password="ALICE_PASS",
      user_domain_name="Default",
      project_domain_name="Default"
  )

  # Lister les serveurs
  for server in conn.compute.servers():
      print(server.name, server.status)
  ```

* **Ansible** → modules `os_server`, `os_network`, etc. utilisent l’API REST.

* **Terraform** → provider OpenStack basé sur l’API.

* **CI/CD (GitLab, Jenkins)** → possible d’automatiser le déploiement d’environnements.

---

## 4. 🔹 Avantages de l’API REST

* **Automatisation complète** : création de VM, réseaux, volumes sans Horizon/CLI.
* **Intégration DevOps** : CI/CD, Infrastructure as Code.
* **Interopérabilité** : scripts en Python, Bash, Go, etc.
* **Multi-tenant et sécurisé** : via Keystone et les tokens.

---

# 📌 En résumé

* **OpenStack = API-first** : chaque service expose une API REST.
* **Keystone** fournit le **token d’authentification**.
* Les actions (Nova, Neutron, Cinder, Glance) se font via des **requêtes HTTP/JSON**.
* Les APIs REST permettent d’automatiser via **scripts, SDKs, Ansible, Terraform, CI/CD**.

---

👉 Veux-tu que je prépare une **séquence complète d’automatisation en API REST** (authentification → création d’image → création de réseau → lancement d’instance) pour avoir un scénario de bout en bout ?
