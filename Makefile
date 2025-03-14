.PHONY: up down logs ps restart build

# Constrói as imagens e levanta os containers em modo detached
up: build
	docker-compose up -d

# Constrói as imagens (útil para quando houver alterações no Dockerfile ou dependências)
build:
	docker-compose build

# Para e remove os containers
down:
	docker-compose down

# Exibe os logs dos containers
logs:
	docker-compose logs -f

# Lista o status dos containers
ps:
	docker-compose ps

# Reinicia os containers (para aplicar alterações, se necessário)
restart: down up
