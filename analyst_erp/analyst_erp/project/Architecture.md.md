# System Architecture

## High Level Architecture

Boss
↓
Analyst Agent
↓
GitHub
↓
Backend / Frontend Team
↓
Application
↓
Database


## Application Architecture

┌─────────────────────┐
│      Frontend       │
│      React/TS       │
└──────────┬──────────┘
           │ API
           ▼
┌─────────────────────┐
│       Backend       │
│      REST API       │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│      Database       │
└─────────────────────┘