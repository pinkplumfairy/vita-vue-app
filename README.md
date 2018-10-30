# Vita App

This Vue.JS app generates your CV based on your given information in the database.

## Getting Started

These instructions will get you a copy with some testdata of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

- A MySQL Database server
- A webserver of your choice for the API and running PHP 7.2
- Node.js

### Installing

Install all dependencies from package.json

```
npm install
```

- Create an empty database on your MySQL server.
- Run the [empty_vita_db.sql](src/database/empty_vita_db.sql) script on your MySQL server to create the database structure.
- When done run the [defaultdata_vita_db.sql](src/database/defaultdata_vita_db.sql) script to fill the database with dummy data.
- Read *Generating the test data* to generate your own set of data or getting a better understanding of the database structure.
- Set up your profile picture
    - Place your picture in *src/assets/images*
    - Go to *src/components/sidebar.vue* and edit the src and alt value of #profile-picture

```html
<img id="profile-picture" src="../assets/images/MyPicture.jpg" alt="My profile picture"/>
```

Edit *php/config/config.php* with your DB login credentials

```PHP
$DB = new Mysql("localhost", "YOURDB", "YOURUSER", "YOURPW");
```

Edit *src/main.js* to point to your API serving webserver

```javascript
var URL = process.env.NODE_ENV !== 'production' ? 'http://your.url' : '';
```

Change title and description of page in *index.html*
```html
<title>My Page</title>
<meta name="description" content="My Page Content">
```

Now you can fire up your hotbuild dev environment with

```bash
npm run dev
```

Give me a shout out for different webserver setup suggestions with PHP and Webpack.

### Generating the test data

See the [ERD](src/database/vita-app-ERD.svg) for more details.

If you want to create you own data, please bear in mind following rules

#### Table language
Define a language key first

Key must be a string with length 2

```sql
insert into language (language)
values ('EN')
```

#### Table text_translation
Define your H1 und menubar text

- each value must have its unique name value and must be linked to an existing language
    1. text: The shown text
    2. language: lanaguage from language.language, unique constraint with text_translations.name
    3. name: foreign key reference for all tables holding translatable text values, unique constraint with text_translations.language

```sql
insert into text_translations (text,language,name)
values ('My heading','EN','heading_desc'), ('My menu bar title','EN','menu_desc')
```

---
**NOTE**

Although the table structure is already set up for multi language support, the *API does not determine beetween different language types* **yet**.
Inserting multiple translations for one text will currently result in multiple rows in the frontend.
This feature will be delivered in a feature version

---

#### Table system
This table needs the following three mandatory rows expected by PHP and Vue
    1. name = version, versionnumber = some int, text = null
    2. name = header, versionnumber = null, text = your text_translations.name for header
    3. name = menu, versionnumber = null, text = your text_translations.name for menu

```sql
insert into system (name,versionnumber,text)
values ('version',1,null),
('header',null,'heading_desc'),
('menu',null,'menu_desc')
```

---
**NOTE**

The column versionnumber is currently only read through PHP for 
```sql
where name = 'version'
```
and must be *incremented manually*, if changes shall be shown to the client

---

#### Table vita_type
Create your main sections here
    1. id: determines the display order
    2. name: determines the HTML id and the menu href link, must be *unique*
    3. text: must be preset in text_translations table, determines the shown h2 element
    4. animatable: generates a hidden animation for this section, if animatble = 1

```sql
insert into text_translations (text,language,name)
values ('My new H2','EN','first_section_desc'), ('The other H2','EN','second_section_desc');
insert into vita_type
values
(1,'first_section','first_section_desc',0),
(2,'second_section','second_section_desc',1);
```

#### Table vita_elements
Fill your section with content
    1. id: determines the display order in the section
    2. name: determines the lefthand text, must be preset in text_translations table
    3. value: determines the righthand text, must be preset in text_translations table
    4. type: link to your section from vita_type.name

```sql
insert into text_translations (text,language,name)
values ('Name','EN','fs_name'),
('Jane Doe','EN','fs_name_desc'),
('Age','EN','fs_age'),
('24','EN','fs_age_desc');
insert into vita_elements (name,value,type)
values ('fs_name','fs_name_desc','first_section'),
('fs_age','fs_age_desc','first_section');
```

#### Table knowledge_level
Create knowledge levels for your knowledge sections
    1. name: currently supported values
        - twenty_percent
        - forty_percent
        - sixty_percent
        - eighty_percent
    2. text: determines the mouseover/print text, must be preset in text_translations table

```sql
insert into text_translations (text,language,name)
values ('Fair enough','EN','basic'),
('Kinda good','EN','good'),
('Advanced','EN','advanced'),
('I know what I''m doing','EN','verygood');
insert into knowledge_level (name,text)
values ('twenty_percent','basic'),
('forty_percent','good'),
('sixty_percent','advanced'),
('eighty_percent','verygood');
```

---
**NOTE**

Supported values can be easily changed/ajusted when editing the CSS in [vita-knowledge.vue](srv/components/vita/vita-knowledge.vue)

---

#### Table skill_type
Create subsections for your knowledge sections
    1. id: determines display order
    2. name: determines objectname in API
    3. text: determines H3 text, must be preset in text_translations table
    4. vita_type: link to your section from vita_type.name

```sql
insert into text_translations (text,language,name)
values ('Programming','EN','prog_desc');
insert into skill_type 
values (1,'programming','prog_desc','second_section_desc');
```

---
**NOTE**

Having a section with *vita_type* and *skill_type* at the same time is currently **not supported**.

---

#### Table skills
Add some content and bars to your skill subsections
    1. id: determines display order
    2. name: determines shown text, must be preset in text_translations table
    3. level: link to knowledge_level.name
    4. type: link to skill_type.name

```sql
insert into text_translations (text,language,name)
values ('Javascript','EN','js');
insert into skills (name,level,type)
values ('js','eighty_percent','programming');
```

#### Now you're good to go!

Read *Update your data* if you want to change anything.

### Update your data

You may update your data in the database at anytime, and show it to the client when ready.

Vue stores all the data from the API call in the local storage, so the site can be viewed offline.

The currently saved versionnumber will always be send to the API and PHP will *only send fresh data* from the database if the send version != system.versionnumber.

Therefore updated data **will not be shown** unless **system.versionnumber is not changed** to another value.


## Tests

Will be added in future version

## Deployment

Deployment files will be generated through

```
npm run build
```

For live deployment, deploy the following:
- index.html
- favicon.ico
- favicon_32.png
- favicon_96.png
- mstile-144x144.png
- apple_touch_icon.png
- manifest.json
- icons-192.png
- icons-512.png
- /dist

## Built With

* [Vue](https://vuejs.org/) - The web framework used
* [anime.js](http://animejs.com/) - Used for JS animations
* [Webpack](https://webpack.js.org/) - Used for bundeling
* [NPM](https://www.npmjs.com/) - Used for package management
* [PHP](http://php.net/) - Used for the API
* [MySQL](https://www.mysql.com/) - Used for data storage

## Versioning

[SemVer](http://semver.org/) is used for versioning.

## Authors

* **Olga Hedderich** - *Frontend, Database Design, Animations* - [PinkPlumFairy](https://github.com/pinkplumfairy)
* **Michael Hedderich** - *PHP & API backend magic*


## To Do

- Add tests
- implement multi language support in PHP and frontend
