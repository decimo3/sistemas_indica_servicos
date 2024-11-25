up:
		docker compose down
		docker image rm presence_list_page-php
		docker compose up --detach