# 🌍 City Air Quality Viewer

This project is a PHP-based web app that visualizes historical air quality data (PM2.5 and PM10) for major cities around the world using Chart.js. It allows users to select a city and view monthly pollutant concentration trends.

## ✨ Features

- 🔍 Browse and select cities with available air quality data
- 📊 Dynamic charts rendered using Chart.js (line graphs)
- 📅 Monthly average calculations for PM2.5 and PM10
- 📁 Uses `.json.bz2` compressed files for optimized data storage
- 📌 Simple and clean UI with responsive layout

## 🚀 Tech Stack

- PHP (Core logic and data handling)
- Chart.js (for interactive chart rendering)
- HTML/CSS (structure and styling)
- JSON (.bz2 compressed files for data)
- JavaScript (Chart library)

## 📁 Project Structure

.
├── city.php # Detail page for individual city data
├── index.php # Main page listing cities
├── inc/
│ └── functions.inc.php # Custom helper functions
├── data/ # Air quality data for each city (compressed)
│ ├── *.json.bz2
│ └── index.json # Metadata for cities
├── views/
│ ├── header.inc.php
│ └── footer.inc.php
├── scripts/
│ └── chart.umd.js # Chart.js library
└── styles/
└── simple.css # Stylesheet


## 🧠 Notable PHP Concepts Used

- File handling: `file_get_contents()`, `bz2` decompression
- Data decoding: `json_decode()`
- Ternary operators and conditionals
- Query parameters via `$_GET`
- Arrays and associative arrays
- Basic templating with `include` / `require`
- Chart.js integration with PHP-generated data

## 🌐 How it Works

1. `index.php` loads `index.json` to show all available cities.
2. When a user clicks a city, `city.php` extracts data from the corresponding `.json.bz2` file.
3. The data is parsed, aggregated by month, and visualized using Chart.js.
4. Results are also shown in a fallback table below the chart.

## 🛠️ Installation

1. Clone the repo:
   ```bash
   git clone https://github.com/YOUR_USERNAME/city-air-quality-viewer.git
   cd city-air-quality-viewer