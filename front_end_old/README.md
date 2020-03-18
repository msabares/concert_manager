# Front End
The main focus of the front end is to authenticate and authorize users properly. What makes this possible is the use of the following:
* [jwt token](https://jwt.io/) is what we receive from our api and holds the appropriate data for the front end to use.
* [Vuex](https://vuex.vuejs.org/) to store the user's jwt token locally and allow components use it's data globally.
* [Vue Router](https://router.vuejs.org/) to route users to the appropriate page depending on their authentication and authorization.

## Getting Started
The front end is built using Vue CLI for Vue.JS development. To get started, you'll need Vue CLI installed and install any dependencies/packages.

### Prerequisites
Before installing Vue CLI, you'll need [Node.JS](https://nodejs.org/en/) version 8.9 or above.

### Install Vue CLI
```
yarn global add @vue/cli
```
[Source](https://cli.vuejs.org/guide/installation.html)

### Install Dependencies
Within the front_end directory, use the following command.
```
yarn install
```

## Useful Commands
### Compile project during development
```
yarn serve
```

### Compile project for deployment
```
yarn build
```
