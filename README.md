
<h1 align="center">Simple Pokémon Teambuilder</h1>
<p align="center">
  A school project for the course <strong>COS30043 - Interface Design and Development</strong> that lets you create and share simple Pokémon teams.
</p>
<p align="center">
  <a href="http://ec2-13-55-35-161.ap-southeast-2.compute.amazonaws.com">
    <img src="https://img.shields.io/badge/Live%20Demo-Visit%20Now-blue?style=for-the-badge" alt="Live Demo">
  </a>
</p>
<p align="center">
  <em>Note: The live demo will be available until 1 September 2025.</em>
</p>

<details>
  <summary>📑 Table of Contents</summary>

- [About The Project](#about-the-project)
- [Getting Started](#getting-started)
- [Installation](#installation)
- [Usage](#usage)
- [Contact](#contact)
- [Acknowledgments](#acknowledgments)

</details>

---

## About The Project

![Teambuilder Screenshot](assets/teambuilderScreenshot.png)

**Simple Pokémon Teambuilder** is a school project that allows you to form a simple Pokémon team. It is *simple* because:
- Supports **Generation 1 only**
- No moveset feature (yet)

However, despite that limitation, it includes:
- A public **Teams Gallery** where you can browse others’ teams.
- Ability to **like** teams you admire.
### Built With
- [![Vue.js](https://camo.githubusercontent.com/7ee502068c9b87eb84df40ef974addabb7ad25ff9d53c19ee793555ecd7ea509/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f5675652e6a732d3335343935453f7374796c653d666f722d7468652d6261646765266c6f676f3d767565646f746a73266c6f676f436f6c6f723d344643303844)](https://vuejs.org/)
- [![Vuetify](https://img.shields.io/badge/Vuetify-1867C0?style=for-the-badge&logo=vuetify&logoColor=AEDDFF)](https://vuetifyjs.com/)
- [![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
- [![SQLite](https://img.shields.io/badge/SQLite-07405E?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
---

## Getting Started

Before setting up the project, ensure you have installed:
- [Composer (latest version)](https://getcomposer.org/)
- [Node.js and npm (latest version)](https://nodejs.org/)
- [SQLite](https://www.sqlite.org/download.html)
---

## Installation

1. **Clone the repository**
```bash
git clone https://github.com/baotan1909/simple-pokebuilder.git
cd simple-pokebuilder
```
2. **Backend setup**
```bash
cd backend
composer install
```
**Set up a Local Host Environment**

You’ll need to run the backend on a local server environment of your choice, such as:
- PHP’s built-in development server
- Apache (e.g., via XAMPP, MAMP, WAMP)
- Any other hosting setup you prefer

**Configure Environment Variables**

- Copy the example .env file:
``` bash
cp .env.example .env
```
- Open `.env` in your editor and replace the placeholder value with your actual configuration.

**Notes**: The `GOOGLE_REDIRECT_URI` must match the redirect URI configured in your Google API Console.

3. **Frontend setup**
``` bash
cd ../frontend
npm install
```
**Configure Environment Variables**

- Copy the example .env file:
```bash
cp .env.example .env
````
- Open `.env` in your editor and replace the placeholder value with your actual configuration.

4. **Start the Dev Server**
```bash
npm run dev
```
5. **Access the App**
```bash
http://localhost:<your-port>
```
*Replace `<your-port>` with the one shown in your terminal after running npm run dev.*

## Usage
> **Note:** For the full experience, you need to log in with your Google account.
1. **Create a Team**  
![Create a Team GIF](assets/createTeam.gif)
2. **Browse Other Teams**  
![Browse Other Teams Screenshot](assets/teamsGallery.png)
3. **Explore the Pokédex**  
![Explore the Pokédex Screenshot](assets/pokedex.png)
## Contact
Thái Dương Bảo Tân – baotan1909@gmail.com
## Acknowledgments
- Thanks to [**PokéAPI**](https://pokeapi.co/) for providing a comprehensive and freely accessible API for Pokémon data.  
- All Pokémon content and materials are **&copy; The Pokémon Company**. This project is a fan-made work and is not affiliated with or endorsed by The Pokémon Company.
