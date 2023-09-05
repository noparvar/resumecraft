# ResumeCraft

**ResumeCraft** is a PHP-based application that generates professional resumes in PDF format from JSON data using the mPDF library and Twig templating engine. This tool allows you to easily create and customize your resume by providing your data in a structured JSON format and then generating a well-designed PDF resume document.

## Features

- **Customizable Resume:** Easily customize your resume by editing a JSON file containing your personal information, work experiences, education, skills, awards, languages, and more.

- **PDF Generation:** ResumeCraft uses the mPDF library to convert your structured data and templates into a high-quality PDF resume, ensuring a professional and visually appealing output.

- **Template-Based:** The application utilizes Twig templates for each section of the resume, making it straightforward to modify the layout and styling to meet your preferences.

## Prerequisites

Before using ResumeCraft, make sure you have the following dependencies installed:

- PHP (>=8.0)
- Composer (for installing PHP packages)
- mPDF library
- Twig templating engine

## Installation

1. Clone the ResumeCraft repository to your local machine or download the ZIP file.

```bash
git clone https://github.com/noparvar/resumecraft.git
```

2. Navigate to the project directory:

```bash
cd resumecraft
```

3. Install PHP dependencies using Composer:

```bash
composer install
```

## Customize your resume
you can customize your resume data by editing the data.json file located in the project root. You can structure your resume data as per the provided template.

Please note that there are several templates available by default, based on Twig, with names matching the keys in the `data.json` file.

* If you wish to remove one of the built-in resume sections, simply delete the corresponding key from the `data.json` file.
* If you want to change the order of sections, you can rearrange the corresponding keys in the `data.json` file.
* If you'd like to add a new template, simply create a Twig file in the `templates` directory with the same name as the corresponding key in `data.json`. The filename, without the '.twig' extension, should match the key in `data.json`.

This flexibility allows you to customize your resume by modifying the data and templates according to your preferences.


## Usage

To generate your resume in PDF format, follow these steps:

1. Open a web browser and navigate to the project directory by accessing http://localhost/path-to-resumecraft/public/index.php in your browser, where path-to-resumecraft is the path to the project directory on your local web server.

2. Your resume will be automatically generated and displayed in the browser.

3. To save the resume as a PDF file, use the save functionality to save the page as a PDF document.

## License

This project is licensed under the [GPLv2](https://www.gnu.org/licenses/gpl-2.0.html).