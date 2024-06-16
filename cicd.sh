#!/bin/bash

REPO_URL="https://github.com/deklaswas/website.git"
BRANCH="main"
WORKSPACE="/var/www/website"

if [ ! -d "$WORKSPACE" ]; then
  git clone "$REPO_URL" "$WORKSPACE"
else
  cd "$WORKSPACE"
  git fetch
  CHANGES=$(git rev-list HEAD..origin/$BRANCH --count)

  if [ "$CHANGES" -gt 0 ]; then
   echo "New changes detected. Running CI/CD pipeline..."
   git pull
   echo "CI/CD pipeline completed."
  else
    echo "No new changes detected. CI/CD pipeline not needed."
  fi
fi
