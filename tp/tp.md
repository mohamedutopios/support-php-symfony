Voici un projet simple découpé en deux parties :

---

### 🔷 Partie 1 : API Express + stockage JSON

#### 📁 Structure de l’API :

```
api/
├── data/
│   └── db.json              # Stockage des données
├── routes/
│   └── posts.js             # Routes de l'API
├── app.js                   # Point d'entrée Express
├── package.json
```

#### 📦 Installation des dépendances :

```bash
npm init -y
npm install express body-parser cors
```

---

#### 📄 `data/db.json` (données de départ) :

```json
[
  {
    "id": 1,
    "title": "Premier post",
    "content": "Ceci est le contenu du premier post"
  }
]
```

---

#### 📄 `routes/posts.js`

```js
const express = require('express');
const fs = require('fs');
const path = require('path');
const router = express.Router();

const dbPath = path.join(__dirname, '../data/db.json');

function readData() {
  return JSON.parse(fs.readFileSync(dbPath));
}

function writeData(data) {
  fs.writeFileSync(dbPath, JSON.stringify(data, null, 2));
}

router.get('/', (req, res) => {
  const posts = readData();
  res.json(posts);
});

router.post('/', (req, res) => {
  const posts = readData();
  const newPost = {
    id: Date.now(),
    title: req.body.title,
    content: req.body.content
  };
  posts.push(newPost);
  writeData(posts);
  res.status(201).json(newPost);
});

module.exports = router;
```

---

#### 📄 `app.js`

```js
const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const postsRoutes = require('./routes/posts');

const app = express();
const PORT = 3000;

app.use(cors());
app.use(bodyParser.json());
app.use('/api/posts', postsRoutes);

app.listen(PORT, () => {
  console.log(`API listening on http://localhost:${PORT}`);
});
```

---

### 🔷 Partie 2 : Mini front HTML/JS (vanilla)

#### 📁 Structure :

```
web/
├── index.html
├── script.js
```

---

#### 📄 `index.html`

```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Mini Blog</title>
</head>
<body>
  <h1>Mini Blog</h1>
  <form id="postForm">
    <input type="text" id="title" placeholder="Titre" required />
    <br />
    <textarea id="content" placeholder="Contenu" required></textarea>
    <br />
    <button type="submit">Envoyer</button>
  </form>
  <hr />
  <div id="posts"></div>
  <script src="script.js"></script>
</body>
</html>
```

---

#### 📄 `script.js`

```js
const postForm = document.getElementById('postForm');
const postsDiv = document.getElementById('posts');
const apiUrl = 'http://localhost:3000/api/posts';

function afficherPosts() {
  fetch(apiUrl)
    .then(res => res.json())
    .then(posts => {
      postsDiv.innerHTML = posts.map(post => `
        <h3>${post.title}</h3>
        <p>${post.content}</p>
        <hr />
      `).join('');
    });
}

postForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const title = document.getElementById('title').value;
  const content = document.getElementById('content').value;

  fetch(apiUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ title, content })
  })
    .then(() => {
      postForm.reset();
      afficherPosts();
    });
});

afficherPosts();
```

---

### 🚀 Lancement :

1. **API** :

   ```bash
   node app.js
   ```
2. **Web** :
   Ouvre `web/index.html` dans ton navigateur (tu peux aussi le servir avec `python -m http.server` ou `live-server`).

---

Souhaites-tu aussi une version Dockerisée ou un script cloud-init pour la VM ?
