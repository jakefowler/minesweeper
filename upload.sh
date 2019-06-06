#!/bin/bash

## change to the directory of the script
SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do
  DIR="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )"
  SOURCE="$(readlink "$SOURCE")"
  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE"
done
SD="$( cd -P "$( dirname "$SOURCE" )" >/dev/null 2>&1 && pwd )"; cd $SD

remote=web@ec2-18-218-76-101.us-east-2.compute.amazonaws.com:/var/www/html/minesweeper
rsync -azP --delete --filter=":- .gitignore" --exclude=.git --exclude=.gitignore --exclude=.idea --exclude=upload.sh --exclude=sql . $remote


