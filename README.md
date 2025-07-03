# Alternative Web Platform

A web-based collaboration platform built with PHP, HTML, JavaScript, and CSS. Features user authentication, discussion rooms, and dynamic messaging similar to a forum/chat app.

## Features

- User login and registration system
- Discussion hub for posting and interacting
- Real-time chart/message updating (via PHP backend)
- Modular backend handling via connection layers
- UI designed for clarity and ease of use

## Tech Stack

- PHP (backend logic)
- HTML/CSS/JavaScript (frontend)
- MySQL (assumed for DB from PHP structure)

## Project Structure

- `App/html/`: Pages for login, register, discussions
- `App/Connections/`: Handles DB interactions
- `App/scripts/`: JavaScript logic for dynamic behavior
- `App/css/`: Custom styles for various pages
- `Snapshots/`: UI previews

## Running Locally

1. Place the project in your local web server root (`htdocs/` for XAMPP, etc.)
2. Setup your database schema (not included, assumed from code)
3. Access via `http://localhost/AlternativeWeb-main/App/html/login-register`
