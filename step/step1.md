Pour créer un projet web nommé `demo-cpam` avec Symfony en utilisant le CLI Symfony, tu peux suivre ces étapes simples et les commandes associées :

1. **Installation de Symfony CLI**  
   Si tu n'as pas déjà installé Symfony CLI, tu peux le faire via cette commande :
   ```bash
   curl -sS https://get.symfony.com/cli/installer | bash
   ```

2. **Création du projet**  
   Utilise la commande suivante pour créer un nouveau projet Symfony :
   ```bash
   symfony new demo-cpam --webapp
   ```
   L'option `--webapp` permet de créer un projet web complet avec toutes les dépendances typiques pour une application web, y compris les contrôleurs, les templates et les assets.

3. **Démarrage du serveur local**  
   Une fois le projet créé, navigue dans le dossier du projet et démarre le serveur de développement local avec :
   ```bash
   cd demo-cpam
   symfony server:start
   ```
   Cela lancera un serveur de développement accessible via `http://localhost:8000` par défaut.

4. **Ouverture du projet**  
   Pour ouvrir le projet dans ton éditeur de code préféré (si tu utilises Visual Studio Code, par exemple) :
   ```bash
   code .
   ```

Ces étapes te donneront un projet de base prêt pour le développement. Tu peux ensuite ajouter des contrôleurs, des entités, des templates et d'autres dépendances selon les besoins de ton application.