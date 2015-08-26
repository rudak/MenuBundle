# MenuBundle
Simple Bundle de gestion des menus


## Installation
**Composer.json** :```"rudak/menu-bundle": "dev-master"```    
**Kernel** : ```new Rudak\MenuBundle\RudakMenuBundle()```

## Utilisation

Il faut commencer par configurer les items du menu, dans config.yml de cette facon :
    
    items:
        - { index: Accueil, route: homepage, title: 'Accueil du site' }
        - { index: Administration, route: game_main_admin, title: 'Administration du site' }
    hierachy:
        blog: ['mon_article','liste_articles_full'] #optionnel
    configuration:
        current_classname: yes  #optionnel
        other_classname: no     #optionnel
            
Ensuite il faut placer l'appel du controller ```{{ render(controller('RudakMenuBundle:Include:getHtmlMenu')) }}``` dans votre vue sensée afficher le menu, chez moi c'est un menu *bootstrap classique* qui se trouve dans ```'::main-menu.html.twig'```. Par contre le menu ne renvoie que les elements LI vu qu'il y a plein de classes dans mon UL, ca va plus vite. On peut forcer l'envoie d'un UL contenant l'ID ```main_menu``` enveloppant tout ca en ajoutant le parametre **wrapper = true** a l'appel du controller, dans le Twig. Par défaut, le wrapper est False. 

Voila à quoi ce Twig ressemble :
    
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">
                    MonSite.fr
                </a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
                    {{ render(controller('RudakMenuBundle:Include:getHtmlMenu',{'wrapper':false})) }}
                </ul>    
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>

## Fonctionnement

Voila, le menu sera appelé tout seul à chaque affichage de votre page, maintenant il faut signaler sur quelle page on se trouve pour que l'onglet correspondant prenne la classe 'active'. Et c'est désormais un listener qui s'occupe de ca tout seul à chaque requetes. Donc en gros, une fois la requete lancée, le listener chope le nom de la route et la place en session (avec la clé définie en constante dans MenuHandler). Ensuite il s'agit juste d'une simple comparaison de l'item de menu a afficher et de celui en session pour savoir si il faut attribuer la classe active ou pas. C'est un peu plus compliqué pour ce qui est de la hierarchie mais le code est commenté donc c'est pas sorcier. Bref, ca marche tout seul ^^ 

## Hierarchie

Sur un de mes sites, la partie blog et ses articles me posaient probleme. Je voulais que mes articles dépendent de l'onglet blog (onglet actif). Pour cette raison j'ai créé un systeme de hierarchie, configurable dans ```config.yml``` comme ceci :

    rudak_menu:
        items:
            // ......
        hierachy:
            monBlog: ['mon_article','liste_articles_full']
            papa: ['fils','fille','chien','chat']

C'est assez simple à comprendre et ca correspond mieux à ce que je voulais. Comme ca, si on a un onglet actualités par exemple, il sera actif aussi bien pour la liste des actus que pour les actus elles memes. Ca peut etre arrangé encore...

    