---
title:              "What is Stenope?"
description:        "Discover Stenope: the static site generator for Symfony developers and its purposes."
publishedAt:        "2022-09-01"
lastModified:       ~
tableOfContent:     true

image:              "content/images/articles/banners/what-is-stenope.jpg"
tags:               ["dev", "stenope"]
authors:            ["tom32i", "ogi", "elao"]
nextArticle:        "guide"
---

## A tailored solution

For our site [at Elao](https://www.elao.com), we were seduced by the approach of the static site automatically generated
from Markdown content.

In the previous version of it, we used [Hugo](https://gohugo.io/), but we also tested 
[many of the existing static generation tools](https://jamstack.org/generators/).  

It has the advantage of serving a high-performance site, with very low susceptibility to attacks and whose content is
controlled through a git workflow: an article is written as a feature, via a PR, with proofreading and validation by
colleagues.

We really liked the concept, but most of the time we felt limited by these solutions: the source code that was too closed
or difficult to extend. So, either we adapt our needs to what the solution is capable of offering, or we accumulate workarounds…

But at Elao, we consider ourselves as artisans. So this time, we wanted to be completely free, have total control over 
the solution and no longer depend on a project or language we don't know well.

Hence, we developed a simple tool, for PHP developers, that can be used over any Symfony web-app and tailored to any needs.

## Symfony + Static = Stenope

As Symfony experts, it was the evidence: to completely master our code base, let's develop our site with Symfony, then
serve it statically!

So we started developing [Stenope](https://stenopephp.github.io/Stenope/), a simple tool registered as a bundle and
relying on the Symfony HTTP Kernel to generate a static site.

> Stenope generates a static site from any Symfony project.

!!! Info
    Stenope [is referenced](https://jamstack.org/generators/stenope/) in the static generators sections
    of the [Jamstack initiative](https://jamstack.org/).

### Philosophy

Stenope was designed with these goals in mind:

- Stenope meets your needs, not the other way around. No structure nor format is imposed.
- Stenope runs in any Symfony project out of the box, connects with standard Symfony components and feels natural to
  Symfony developers.
- Stenope is highly extensible: features can be replaced, added or removed.

The bundle also comes with a handy set of content manager, providers & tools to help you generate pages from YAML,
Markdown or JSON content files (or virtually any format supported by Symfony's Serializer or your owns).

### How it works

- 🔍 Stenope scans your Symfony app (like a search engine crawler would) and dumps every page into a static HTML file.
- 🛠 Stenope provides tools for loading and parsing various data sources (like local Markdown files or distant headless
  CMS).
- 🖌 Stenope enriches the parsed data by applying a series of processors (like Syntax Highlighting, slug generation,
  etc.).
- 🧲 Stenope finally hydrates your custom PHP objects with the enriched data and provides interfaces for listing and
  retrieving them (like an ORM would).
- ⚙️ Stenope gives you a lot of control over the whole process by providing entrypoints, interfaces and default
  implementations that are entirely replaceable.

### What Stenope is not

Stenope is not a ready-to-use blogging system: but you could quickly write your own blog system with it!

It strictly targets Symfony developers & web integrators to build the content management system of their dreams.  
But once the engine is set up, anybody should be able to write content.
