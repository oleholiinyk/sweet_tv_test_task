### Docker Compose

The `docker-compose.yml` file sets up the following services:

* `db`: MySQL database
* `api`: Laravel API backend
* `app`: Vue.js frontend
* `nginx`: Nginx server

## Running the Application

1. **Build and Start Services**

   From the root directory of your project, execute:

   ```bash
   docker-compose up --build
This command builds the Docker images for the api and app services and starts all services defined in the docker-compose.yml file.

## Accessing the Application

- **Frontend (Vue.js):** Navigate to `http://localhost:8000` in your web browser.
- **Backend (Laravel API):** Access the Laravel API at `http://localhost:8080`.
- **Nginx:** The Nginx server is accessible at:
    - `http://localhost:8080`
    - `http://localhost:8000`

## Stopping the Application

To stop and remove the running containers, use the following command:

```bash
docker-compose down
