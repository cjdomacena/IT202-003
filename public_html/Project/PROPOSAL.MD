# Project Name: Simple Shop

## Project Summary: This project will create a simple e-commerce site for users. Administrators or store owners will be able to manage inventory and users will be able to manage their cart and place orders

## Github Link: [Production Branch](https://github.com/cjdomacena/IT202-003/tree/production)

## Project Board Link: [Project Board](https://github.com/cjdomacena/IT202-003/projects/1)

## Website Link: [Heroku Prod](https://cd395-prod.herokuapp.com/Project/login.php)

## Your Name: Christian Domacena

<!--
### Line item / Feature template (use this for each bullet point)
#### Don't delete this

- [ ] \(mm/dd/yyyy of completion) Feature Title (from the proposal bullet point, if it's a sub-point indent it properly)
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
### End Line item / Feature Template
-->

### Proposal Checklist and Evidence

<details>
<summary><strong>Milestone 1</strong></summary>

- [x] Milestone 1

  - [x] (10/18/2021) User will be able to register a new account

    - List of Evidence of Feature Completion

      - Status: (Incomplete)(It wipes the email and username when email/username is taken upon submission)

      - [Initial register.php from slides](https://github.com/cjdomacena/IT202-003/pull/34/commits/8a36c500b63f27a9a4a168e08ebc939496fb31cc#diff-a6efd6bcdcc38b7d158885263301aac736d98718cecbb4d34a946211a9a655ae)
      - [Direct link to file (Most recent)](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/register.php)

    - Pull Request/s

      - [Pull Request #34](https://github.com/cjdomacena/IT202-003/pull/34/commits/8a36c500b63f27a9a4a168e08ebc939496fb31cc#diff-a6efd6bcdcc38b7d158885263301aac736d98718cecbb4d34a946211a9a655ae)

      - [Pull Request #67](https://github.com/cjdomacena/IT202-003/pull/67)

        - (11/11/2021) some flash parameters to be updated using tailwind.

    - Screenshots

      - Register form with styling.

        - ![image](https://user-images.githubusercontent.com/67976753/141268895-23179f97-8d62-456c-a698-1379aefa1103.png)

      - Register with password errors

        - Passwords match, but does not meet the requirements

          - ![image](https://user-images.githubusercontent.com/67976753/141269763-8989e9e0-a369-44b9-8d6a-f9a19b45e627.png)

        - Password meet requirements, but does not match

          - ![image](https://user-images.githubusercontent.com/67976753/141270119-165a3fe3-e1e3-48a4-b457-e67ab5cccfc8.png)

        - Password does not meet requirements and does not match

          - ![image](https://user-images.githubusercontent.com/67976753/141270328-dfa92dbb-551e-44f1-8fad-74a48d9e78c5.png)

      - Register with Email errors

        - Email already taken (It wipes the form)

          - ![image](https://user-images.githubusercontent.com/67976753/141272281-611a4385-f178-4bf4-9f20-66547615e400.png)

      - Register with username errors

        - Username is already taken (It wipes the form)

          -![image](https://user-images.githubusercontent.com/67976753/141272714-b7e50ca5-ceae-4dde-8239-7d89b2b02aa8.png)

  - [x] (10/11/2021) User will be able to login to their account (given they enter the correct credentials)

    - List of Evidence of Feature Completion

      - Status: (Complete)

      - [Direct link to file (Most recent)](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/login.php)

    - Pull Request/s

      - [Pull Request 60 (Most recent)](https://github.com/cjdomacena/IT202-003/pull/60)

        - Added additional validation using js

      - [Direct link to Commit (PR #39)](https://github.com/cjdomacena/IT202-003/pull/39/commits/c7356a461b085c0aa72afca72e0371ac5608bdad)

        - It got mixed up with my other commits

    - Screenshots

      - Login Form

        - ![image](https://user-images.githubusercontent.com/67976753/141273733-3d2d0f7c-3ff4-460d-8125-62ff7cbe86a8.png).

          - Basic login form.

      - User will be able to login with correct credentials (Using username)

        - ![2021-11-11-04-32-32](https://user-images.githubusercontent.com/67976753/141274289-01e28259-4407-4059-b5c7-0114fdd5fe9f.gif)

        - User logs in using username and will be redirected to home.php.

      - User will be able to login with correct credentials (Using email)

        - ![2021-11-11-04-35-21](https://user-images.githubusercontent.com/67976753/141274677-6ca50626-dd1e-41e3-9123-1b3da43933ce.gif)

        - User logs in using email and will be redirected to home.php.

      - Login Validation

        - Invalid email (does not exist)

          - ![image](https://user-images.githubusercontent.com/67976753/141275057-9d85e32d-4bb4-41d8-abe2-6be1158a2ca2.png)

          - Displays flash when email does not exists.

        - Invalid password

          - ![image](https://user-images.githubusercontent.com/67976753/141275148-c2d5f6f8-c57b-42e5-9663-abc4a1aa475c.png)

          - Displays flash when password is incorrect.

      - Stores session upon successful login

        - ![image](https://user-images.githubusercontent.com/67976753/141275409-008bedef-1e32-41cf-b220-a6dc2a128c29.png)

        - Displays a welcome message using flash with the user's username

        - Displays role

  - [x] (10/18/2021) User will be able to logout

    - List of Evidence of Feature Completion

      - Status: (Incomplete)

        - Flash message doesn't appear when loggin out.

      - Direct Link (https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/logout.php)

    - Pull Request/s

      - [Pull Request #34](https://github.com/cjdomacena/IT202-003/pull/34/)

        - Fell behind about a week, this PR is to get all my Project files updated based on class slides.

      - [Direct link to commit (PR #34)](https://github.com/cjdomacena/IT202-003/pull/34/commits/7a2d6ff17f145627ffdf276595e30be87954fa80)

        - Direct link because I did give the commit a proper name to its appropriate change.

    - Screenshots

      - User will be able to logout

        - ![2021-11-11-04-50-31](https://user-images.githubusercontent.com/67976753/141277107-8da55d33-81c0-487d-ace2-6a729bfb9b90.gif)

        - Flash message does not appear upon logging out.

      - Session is destroyed upon logging out

        - ![2021-11-11-04-55-21](https://user-images.githubusercontent.com/67976753/141277822-5f63aefe-8db8-407e-8262-2eecd65a13e2.gif)

        - After logging out, user will not be able to go back.

    - [x] (25/10/2021) Basic security rules implemented

    - List of Evidence of Feature Completion

      - Status: (Completed)

      - [Nav partials](https://github.com/cjdomacena/IT202-003/blob/production/partials/nav.php)

        - Displays different navigation based on user role.

      - Pull Request/s

        - Nav (Show different nav items based on user role)

        - [Pull Request #38](https://github.com/cjdomacena/IT202-003/pull/38/commits/484ec69acaeb1e30dd08b50c3ba5f690828e2857)

          - This was the initial PR.

          - Was behind about a week and updated nav to catch up based on slides.

    - Screenshots

      - Authentication

        - User with no role (In this case, admin role is disabled for this user)

          - ![image](https://user-images.githubusercontent.com/67976753/141279215-a1215893-8732-4635-9e38-933b1d50e00e.png)

          - Only shows appropriate navigation items based on user role.

        - User is not able to access specific pages based on User's role

          - ![image](https://user-images.githubusercontent.com/67976753/141280732-1ec314af-d4ee-41b5-a5cf-3e1bca78c1e9.png)

          - User will be redirected to home when tried to access, in this case, create_role.php

      - Roles table

        - See below.

    - [x] (25/10/2021) Basic Roles implemented

      - List of Evidence of Feature Completion

        - Status: (Completed)

        - [sql folder](https://github.com/cjdomacena/IT202-003/tree/production/public_html/Project/sql)

      - Pull Request/s

        - [Pull Request #37](https://github.com/cjdomacena/IT202-003/pull/37)

      - Screenshots

        - Users table

        - ![image](https://user-images.githubusercontent.com/67976753/141281622-2cf9c7dd-dbc0-4a33-b5c8-33a5a5e6a56c.png)

        - Displays users table.

        - Roles table

          - ![image](https://user-images.githubusercontent.com/67976753/141281372-96f429ff-8491-4cf5-a56f-8ea3132dc05b.png)

          - Current roles table

        - User Roles table

          - ![image](https://user-images.githubusercontent.com/67976753/141281451-4633b232-a2c2-46fb-9f49-68b54bc199be.png)

          - Pivot table between Roles and Users table (Not sure if its called pivot table)

    - [x] (11/11/2021 with everything styled) Site should have basic styles/theme applied; everything should be styled

      - List of Evidence of Feature Completion

        - Navbar in local env

          ![Local Env](Styles/navbar_local.png)

        - Status: (In progress)

        - [Link to file](https://github.com/cjdomacena/IT202-003/blob/Milestone1/partials/nav.php)

      - Pull Request/s

        - [Navbar / PR #39](https://github.com/cjdomacena/IT202-003/pull/39/commits/2dbeddaee0bec252c154cc5f225ba135dc4381e3)

          - [Dropdown Menu](https://github.com/cjdomacena/IT202-003/pull/55)

        - [List Roles PR#58](https://github.com/cjdomacena/IT202-003/pull/58)

          - [Link to file](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/admin/list_roles.php)

        - [Assign Roles PR#64](https://github.com/cjdomacena/IT202-003/pull/64/commits/1c3ca08dc47416db7da84cd8312176734f8e6d65)

          - [Link to file](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/admin/assign_roles.php)

        - [Create Roles PR#51](https://github.com/cjdomacena/IT202-003/pull/51)

          - [Link to file](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/admin/create_role.php)

        - [Registration & Log in PR#46](https://github.com/cjdomacena/IT202-003/pull/46)

          - [Link to file (Register)](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/register.php)

          - [Link to file(Login)](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/login.php)

        - [Profile Edits (Edit Profile, Reset Password, View Profile)](https://github.com/cjdomacena/IT202-003/pull/62)

          - [Link to file (Edit Profile)](https://github.com/cjdomacena/IT202-003/blob/development/public_html/Project/profile.php)

          - [Link to file(Reset Password)](https://github.com/cjdomacena/IT202-003/blob/development/public_html/Project/account/reset_password.php)

          - [Link to file(View Profile)](https://github.com/cjdomacena/IT202-003/blob/development/public_html/Project/account/view_profile.php)

      - Screenshots

        - Homepage (index.php)

          - ![image](https://user-images.githubusercontent.com/67976753/141281877-63ff57dd-e35e-4b77-9834-1d6798d3b2a0.png)

          - Displays a simple welcome hero message.

        - Login page

          - ![image](https://user-images.githubusercontent.com/67976753/141282015-4e180553-0ac4-4e54-8239-8e5605e5c4d6.png)

          - Login form

        - Registration page

          - ![image](https://user-images.githubusercontent.com/67976753/141282114-d6cbe573-8099-426f-94f9-bad2674ea138.png)

          - Registration form

        - Homepage for logged in users (home.php) (role = admin)

          - ![image](https://user-images.githubusercontent.com/67976753/141282263-ad66b107-cfda-42f0-beb6-9f8ea5921113.png)

          - Displays a welcome message.

        - Edit profile (profile.php)

          - ![image](https://user-images.githubusercontent.com/67976753/141282365-c683eeb7-cc85-4758-a812-cc42e17797e8.png)

          - Only shows input for email and username

        - Reset password (reset_password.php)

          - ![image](https://user-images.githubusercontent.com/67976753/141282485-bd0634bd-035f-4114-9802-9ee4b64e326c.png)

          - Shows email and username inputs, but user won't be able to edit them.

          - Make users able to reset their password.

        - View Profile (view_profile.php)

          - ![image](https://user-images.githubusercontent.com/67976753/141282658-79047644-cb54-4347-9d38-aed95756d0b7.png)

          - Shows disabled inputs for username and email

        - Create Role

          - ![image](https://user-images.githubusercontent.com/67976753/141282764-2acd8137-a7fd-4ef1-8aa6-2245a89a38e6.png)

          - Inputs for creating roles

        - List Roles

          - ![image](https://user-images.githubusercontent.com/67976753/141282826-bc9c1d57-e6bd-4b0d-aca8-ecc3f9b388ec.png)

          - Displays a table of roles

        - Assign Roles

          - ![image](https://user-images.githubusercontent.com/67976753/141282885-7c0dea51-6996-45ab-a9bd-8554cce9e464.png)

          - This is the default view

          - ![image](https://user-images.githubusercontent.com/67976753/141282986-bb32651a-6dee-4b3d-ae0a-5363623bae9c.png)

          - View with all the users

    - [x] (11/10/2021) Any output messages/errors should be “user friendly”

      - List of Evidence of Feature Completion

        - Status: (Completed)

        - [Registration](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/register.php)

        - [Login](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/login.php)

      - Pull Request/s

        - [Pull Request #33](https://github.com/cjdomacena/IT202-003/pull/33)

          - Flash based on slides

          - There's more changes to flash throughout the project, but I failed to keep track of them upon changing to tailwind

      - Screenshots

        - Login errors

          - ![image](https://user-images.githubusercontent.com/67976753/141285435-daf7acb7-565d-4f9d-a257-a73e974fc235.png)

          - Display user friendly errors

        - Registration Errors (JS Validation)

          - ![image](https://user-images.githubusercontent.com/67976753/141285909-5ff0ff94-5036-499e-a188-e8f0a0f445ee.png)

          - Flash using helper.js

        - Registration Erros (PHP validation)

          - Register with password errors

            - Passwords match, but does not meet the requirements

              - ![image](https://user-images.githubusercontent.com/67976753/141269763-8989e9e0-a369-44b9-8d6a-f9a19b45e627.png)

            - Password meet requirements, but does not match

              - ![image](https://user-images.githubusercontent.com/67976753/141270119-165a3fe3-e1e3-48a4-b457-e67ab5cccfc8.png)

            - Password does not meet requirements and does not match

              - ![image](https://user-images.githubusercontent.com/67976753/141270328-dfa92dbb-551e-44f1-8fad-74a48d9e78c5.png)

          - Register with Email errors

            - Email already taken (It wipes the form)

              - ![image](https://user-images.githubusercontent.com/67976753/141272281-611a4385-f178-4bf4-9f20-66547615e400.png)

          - Register with username errors

            - Username is already taken (It wipes the form)

              -![image](https://user-images.githubusercontent.com/67976753/141272714-b7e50ca5-ceae-4dde-8239-7d89b2b02aa8.png)

        - Reset Password (JS Validation)

          - ![image](https://user-images.githubusercontent.com/67976753/141286264-92b8aa89-32d8-48f6-86f2-ae8a0f6dcf96.png)

            - Password does not match and does not meet requirements

        - Reset Password (PHP validation)

          - ![image](https://user-images.githubusercontent.com/67976753/141286621-800fac20-3da3-48d7-8f83-0592968266d3.png)

          - New password and confirm password match and meet requirements, but current password is incorrect.

        - List Roles

          - ![image](https://user-images.githubusercontent.com/67976753/141286763-857e7983-a7b5-4dbd-891b-52b84386ec61.png)

          - When filtering displays a flash message.

        - Assign Roles

          - ![image](https://user-images.githubusercontent.com/67976753/141286854-7b7b90f5-24ea-45cc-a41e-27fc8530b634.png)

          - Shows warning message when searching and username field is empty.

    - [x] (11/11/2021 of completion) User will be able to see their profile

      - List of Evidence of Feature Completion

        - Status: (Completed)

        - [Link to file](https://github.com/cjdomacena/IT202-003/blob/production/public_html/Project/account/view_profile.php)

      - Pull Request/s

        - [Pull Request #62](https://github.com/cjdomacena/IT202-003/pull/62)

          - [Link to specific commit](https://github.com/cjdomacena/IT202-003/pull/62/commits/4979bfa251e65cd7f8b2029bde9224cb368f1669)

      - Screenshots

        - ![image](https://user-images.githubusercontent.com/67976753/141287224-59985a97-205c-4641-94a1-ec8c2e6db6f7.png)

        - Only shows email and username (for now)

    - [x] (11/11/2021) User will be able to edit their profile

      - List of Evidence of Feature Completion

        - Status: (Complete)

        - [Link to file (Edit Profile)](https://github.com/cjdomacena/IT202-003/blob/development/public_html/Project/profile.php)

        - [Link to file(Reset Password)](https://github.com/cjdomacena/IT202-003/blob/development/public_html/Project/account/reset_password.php)
        - [Link to file(View Profile)](https://github.com/cjdomacena/IT202-003/blob/development/public_html/Project/account/view_profile.php)

      - Pull Request/s

        - [Profile Edits (Edit Profile, Reset Password, View Profile) PR #62](https://github.com/cjdomacena/IT202-003/pull/62)

      - Screenshots

        - Edit Profile

          - Success

            - ![image](https://user-images.githubusercontent.com/67976753/141288114-eff90313-1b0e-4609-a605-f8fdf3ca0180.png)

              - Displays success upon successful update of username.

            - ![image](https://user-images.githubusercontent.com/67976753/141288225-a3218ede-3936-4b61-b64f-c0c6d2bf2b66.png)

              - Displays success upon successful update of email.

          - Errors

            - ![image](https://user-images.githubusercontent.com/67976753/141288428-c696b45b-0338-40d3-bade-b7aa11e9bc67.png)

              - Displays an error when email is taken.

            - ![image](https://user-images.githubusercontent.com/67976753/141288515-38ab18e3-4103-41ed-876c-32dbcd4d03a3.png)

              - Displays an error when username is taken.

        - Reset Password

          - Success

            - ![image](https://user-images.githubusercontent.com/67976753/141288795-a3b05d27-1f95-4c8b-8455-f0698256f778.png)

              - Displays success message upon successful password reset/change

          - Errors

            - Reset Password (JS Validation)

              - ![image](https://user-images.githubusercontent.com/67976753/141286264-92b8aa89-32d8-48f6-86f2-ae8a0f6dcf96.png)

                - Password does not match and does not meet requirements

            - Reset Password (PHP validation)

              - ![image](https://user-images.githubusercontent.com/67976753/141286621-800fac20-3da3-48d7-8f83-0592968266d3.png)

              - New password and confirm password match and meet requirements, but current password is incorrect.

        - View Profile

          - ![image](https://user-images.githubusercontent.com/67976753/141288320-b8a275ff-efaa-4a02-abc8-d0f9ded6c890.png)

            - Displays profile info

</details>
  
<details open>
<summary><strong>Milestone 2</strong></summary>

- [ ] \(mm/dd/yyyy of completion) User with an admin role or shop owner role will be able to add products to inventory
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) Any user will be able to see products with visibility = true on the Shop page

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show

- [ ] \(mm/dd/yyyy of completion) Admin/Shop owner will be able to see products with any visibility
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) Admin/Shop owner will be able to see products with any visibility

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show

- [ ] \(mm/dd/yyyy of completion) Admin/Shop owner will be able to edit any product

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show

- [ ] \(mm/dd/yyyy of completion) User will be able to click an item from a list and view a full page with more info about the item (Product Details Page)
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) User must be logged in for any Cart related activity below

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show

- [ ] \(mm/dd/yyyy of completion) User will be able to add items to Cart
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) User will be able to see their cart

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show

- [ ] \(mm/dd/yyyy of completion) User will be able to change quantity of items in their cart
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) User will be able to remove a single item from their cart via button click
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) User will be able to clear their entire cart via a button click

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary) - Screenshot #1 description explaining what you're trying to show
  </details>

- Milestone 3
- [ ] \(mm/dd/yyyy of completion) User will be able to purchase items in their Cart
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) Order Confirmation Page

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show

- [ ] \(mm/dd/yyyy of completion) User will be able to see their Purchase History
  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show
- [ ] \(mm/dd/yyyy of completion) Store Owner will be able to see all Purchase History

  - List of Evidence of Feature Completion
  - Status: Pending (Completed, Partially working, Incomplete, Pending)
  - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
  - Pull Requests
    - PR link #1 (repeat as necessary)
  - Screenshots
    - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
      - Screenshot #1 description explaining what you're trying to show

- Milestone 4

### Intructions

#### Don't delete this

1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
7. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
8. Add, commit, push the related file changes to this branch
9. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
   - Screenshot(s) of the site view (make sure they clearly show the feature)
   - Screenshot of the database data if applicable
   - Describe each screenshot to specify exactly what's being shown
   - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
10. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)


    - Basically add an x to the checkbox markdown along with a date after
      - (i.e.,   - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel

5. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)


    - Merge the Milestone branch into dev, then dev into prod as needed
    - Last two steps are mostly for getting it to prod for delivery of the assignment

7. If the attached issues don't close wait until the next step
8. Merge the updated dev branch into your production branch via a pull request
9. Close any related issues that didn't auto close


    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board
