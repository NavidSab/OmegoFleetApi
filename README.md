API only application (API Platform v3)
- Use PostgreSQL database and Doctrine
- Entities can have only properties as described below
- API resources can have only operations as described below

- Three roles:
  - ROLE_USER (default)
  - ROLE_COMPANY_ADMIN (manages users in their company)
  - ROLE_SUPER_ADMIN (manages all users, should have an option to impersonate any user)

- Two entities:
  - User
    - id (int, automatically assigned on creation, cannot be changed after setting up)
    - name (required, string, max 100 characters, min 3 charaters, requires letters and space only, one uppercase letter required)
    - role (required, string, choice between ROLE_USER, ROLE_COMPANY_ADMIN, and ROLE_SUPER_ADMIN - role USER cannot change it, role COMPANY ADMIN can only set USER role)
    - company (relation to the Company entity, required for USER and COMPANY ADMIN roles, SUPER ADMIN cannot have company)

  - Company
    - id (int, automatically assigned on creation)
    - name (required, string, max 100 characters, min 5 charaters, must be unique in the database)

- These entities should be available as API resources with conditions:
  - User:
    - operations:
      - GET /users, GET /users/{id} - available for all roles, USER and COMPANY ADMIN can see only users from their company, SUPER ADMIN can see all users
      - POST /users - available for SUPERADMIN and COMPANY ADMIN
      - DELETE /users/{id} - available for SUPERADMIN only
  - Company:
    - operations:
      - GET /companies, GET /companies/{id} - available for all roles
      - POST /companies - available for SUPERADMIN only

- All endpoints and logic should be tested
- All validation constraints should be tested