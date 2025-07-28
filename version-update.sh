#!/bin/bash

# Check if version argument is provided
if [ -z "$1" ]; then
  echo "Usage: $0 <new-version>"
  echo "Example: $0 1.2.3"
  exit 1
fi

NEW_VERSION=$1

# Verify the version format (semantic versioning)
if ! [[ $NEW_VERSION =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
  echo "Error: Version must be in format X.Y.Z (e.g., 1.2.3)"
  exit 1
fi

# Get current branch name
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)

# Update version in composer.json (if exists)
if [ -f "composer.json" ]; then
  echo "Updating version in composer.json..."
  sed -i '' "s/\"version\": \".*\"/\"version\": \"$NEW_VERSION\"/g" composer.json
  
  # Commit the version change
  git add composer.json
  git commit -m "Bump version to $NEW_VERSION"
fi

# Create annotated tag
echo "Creating tag v$NEW_VERSION..."
git tag -a "v$NEW_VERSION" -m "Version $NEW_VERSION"

# Push changes and tags to remote
echo "Pushing to remote..."
git push origin $CURRENT_BRANCH
git push origin "v$NEW_VERSION"

echo "Version $NEW_VERSION tagged and pushed successfully!"