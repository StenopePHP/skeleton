---
title:              "Deploy"
description:        "Learn how to deploy your static website"
publishedAt:        "2022-09-11"
lastModified:       ~
tableOfContent:     true

image:              "content/images/articles/banners/deploy.jpg"
tags:               ["deploy", "stenope"]
authors:            ["ogi"]
---

## Deploy

The process of deploying a static website with Stenope is quite straightforward.

1. Build your assets (e.g: with Webpack Encore: `npx encore production`)
2. Build your content with Stenope (`APP_ENV=PROD symfony console stenope:build`)
3. Upload the generated files from the `build/` directory to your server.

### Deploy to GH Pages

This starter kit already provides a Github workflow (`.github/workflows/deploy.yaml`) to deploy your static website to
Github Pages. You can reuse it as is or adapt it to your needs.

You can even build a version of your site into a subdir to generate a preview for each of your PR.
Have a look to [how we generate a preview of the elao_ website](https://github.com/Elao/elao_/blob/master/.github/workflows/deploy_pr_preview.yaml) for each of our PRs.

### Deploy to a server

Deploying to a server is as simple as uploading the generated files from the `build/` directory to your server, 
for instance using `ssh/scp` or `rsync`.

You can have a look to [how we deploy the elao_ website](https://github.com/Elao/elao_/blob/master/.github/workflows/deploy.yaml) to production.
