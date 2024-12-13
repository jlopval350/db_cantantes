# db_cantantes

# Web Application for Singer Management

## Overview
This web application allows the management of singers in a MariaDB database. Users with administrator privileges (root) can perform various CRUD operations and view statistics about the singers stored in the database.

## Features

### Core Functionalities
1. **Add a Singer**
   - Insert new singer records into the database.
   - Required fields: `id`, `name`, `musical genre`, and `greatest hit`.

2. **List Singers**
   - View all singer records currently in the database in a tabular format.

3. **Search for Singers**
   - Find singers by filtering through one or more fields (e.g., name or genre).

4. **Delete a Singer**
   - Remove a specific singer from the database by their unique ID.

5. **Update Singer Information**
   - Modify the details of an existing singer.

6. **Reset Database**
   - Delete all data and recreate the database schema.

### Additional Functionalities
1. **Statistics Module**
   - Provides insights such as:
     - Total number of singers.
     - Most popular musical genre.
     - Singer with the most mentioned hit song.

2. **Backup**
   - Create a backup of the current database.

3. **Top Genres Ranking**
   - Displays a ranking of the top 5 singers based on criteria such as popularity or number of hits.

### Security
- Login system ensures that only authenticated users can access the functionalities.
- Input validation is implemented both in the frontend and backend to avoid SQL injection and ensure data integrity.

### User Interface
- Styled with Bootstrap to provide a responsive and professional look.
- Navigation menu for easy access to all functionalities.

## Setup Instructions
1. **Database Setup**:
   - Create a MariaDB database named `db_iaw_jjlv`.
   - Use the provided SQL script to set up the `singers` table.

2. **Server Configuration**:
   - Ensure PHP and MariaDB are installed on the server.
   - Place all application files in the server's web directory (e.g., `/var/www/html/`).

3. **Accessing the Application**:
   - Open a web browser and navigate to the server's URL.
   - Log in with administrator credentials to begin.

## Future Improvements
- Add advanced search filters (e.g., by year of debut or region).
- Implement APIs for integrating with third-party music databases.
- Enhance the statistics module with visual charts and graphs.

## License
This project is open-source and available under the MIT License.

