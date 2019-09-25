
start:
	make -C api-game/devops/ && \
	make -C api-iam/devops/ && \
	make -C api-lobby/devops/ && \
	make -C api-player/devops/ && \
	make -C message-bus/devops/ && \
	make -C gameserver-battleship/devops/ && \
	make -C webapp-battleship/devops/

stop:
	docker stop $(docker ps --filter "name=battleship" -q)