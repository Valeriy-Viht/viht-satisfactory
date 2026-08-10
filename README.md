# Viht Satisfactory

A self-hosted Factorio-inspired game, built primarily as a hands-on learning project.

## Tech Stack

**Practices & Protocols**  
Conventional Commits · Self-Documenting Code · Null Object Pattern · Test-Driven Development (TDD) · JWT

**Architecture & Infrastructure**  
Client-Server microservice architecture · WebSocket · Docker · Docker Compose · nginx · PostgreSQL

**Backend**  
PHP · Workerman · Fiber · PHPUnit

**Frontend**  
React · Tailwind CSS · shadcn/ui · TanStack React Query · Zustand · Honeydrop · Jest

## Challenges Addressed

- **Concurrency issues**: Race conditions, deadlocks, and starvation.
- **Database pitfalls**: N+1 queries and overuse of `SELECT *`.
- **Code maintainability**: Avoiding the Big Ball of Mud antipattern and God Objects.

## Installation

```bash
cd backend
composer install
cd ../frontend
npm install
```

## Running the Project

```bash
docker compose build
docker compose up
```

- **Client**: [http://localhost:3000](http://localhost:3000)  
- **API**: [http://localhost:8081](http://localhost:8081)

## Documentation

For detailed information, please refer to the `docs/` directory.

## Tests

**Backend**  
```bash
cd backend
composer test
```

**Frontend**  
```bash
cd frontend
npm run test
```

## License

**GNU General Public License**  
Version 3, 29 June 2007