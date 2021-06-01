
create-model-category:
	php artisan make:model Models/Category --all;

create-model-genre:
	php artisan make:model Models/Genre --all;

run-route-list:
	php artisan route:list;

run-tinker:
	 php artisan tinker;

run-migrate-seed:
	php artisan migrate:refresh --seed;

run-unit-tests:
	 vendor/bin/phpunit;

create-category-test-unit:
	php artisan make:test CategoryTest --unit;

create-category-test:
	php artisan make:test Models/CategoryTest;

create-category-controller-test:
	php artisan make:test Http/Controllers/Api/CategoryControllerTest;

create-category-video-table:
	php artisan make:migration create_category_video_table;

create-genre-video-table:
	php artisan make:migration create_genre_video_table;

create-category-genre-table:
	php artisan make:migration create_category_genre_table;

create-rule-genres-categories:
	php artisan make:rule GenresHasCategoriesRule;

create-docker-prod:
	docker build -t rfaguiar1/micro-videos-app-optmized -f Dockerfile.prod .;

run-docker-optmized:
	docker run --name app-optmized -d rfaguiar1/micro-videos-app-optmized;

bash-docker-optmized:
	docker exec -it app-optmized bash;

gcloud-encrypt-service-account:
	gcloud kms encrypt \
 	--ciphertext-file=./storage/credentials/google/service-account-storage.json.enc \
	--plaintext-file=./storage/credentials/google/service-account-storage.json \
	--location=global \
	--keyring=testing-build \
	--key=service-account;

gcloud-decrypt-service-account:
	gcloud kms decrypt \
 	--ciphertext-file=./storage/credentials/google/service-account-storage.json.enc \
	--plaintext-file=./storage/credentials/google/service-account-storage.json \
	--location=global \
	--keyring=testing-build \
	--key=service-account;

create-category-resource:
	php artisan make:resource CategoryResource;

create-category-collection-resource:
	php artisan make:resource CategoryCollection --collection;

