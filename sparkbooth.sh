#!/bin/bash

i=1

#number of files in "gifs"
shopt -s nullglob
numgifs=(~/Sites/gifs/*)
numgifs=${#numgifs[@]}
#add 1
numgifs=$(($numgifs+1))

shopt -s nullglob
for f in ~/Sites/raw/*.jpg
do
	echo "converting $f"
	convert $f -resize 1024 -auto-orient "raw/$i.gif"
	i=$(($i+1))
done

echo "creating /gifs/$numgifs.gif"
gifsicle -O2 --delay=10 --loop --colors 256 raw/1.gif raw/2.gif raw/3.gif raw/2.gif > gifs/$numgifs.gif

echo "moving JPGs to /old (and renaming)"
current_time=$(date "+%Y.%m.%d-%H.%M.%S")
j=1
shopt -s nullglob
for f in raw/*.jpg
do
	mv $f old/$current_time._$j.jpg
	j=$(($j+1))
done

echo "deleting GIF components"
rm raw/*.gif
