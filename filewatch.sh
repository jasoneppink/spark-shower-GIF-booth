#!/bin/bash
while true
do
	sleep 5
	if ls ~/Sites/raw/* 1> /dev/null 2>&1; then
		bash sparkbooth.sh
	fi
done
