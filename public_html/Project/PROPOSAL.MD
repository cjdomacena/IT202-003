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

<details open>
<summary><strong>Milestone 1</strong></summary>

- [ ] Milestone 1

  - [ ] (10/18/2021) User will be able to register a new account

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
        

  - [ ] (10/11/2021) User will be able to login to their account (given they enter the correct credentials)

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
      

  - [ ] (10/18/2021 of completion) User will be able to logout

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
     

    - [ ] (25/10/2021) Basic security rules implemented

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

        - User with no role (In this case, admin role is disabled for this user)
  
          - ![image](https://user-images.githubusercontent.com/67976753/141279215-a1215893-8732-4635-9e38-933b1d50e00e.png)

          - Only shows appropriate navigation items based on user role.
  
        - 

    - [ ] Basic Roles implemented

      - List of Evidence of Feature Completion

        - Status: (In progress, Incomplete, Pending)

        - Direct Link (Direct link to specific file)

      - Pull Request/s

        - [Pull Request #](insertLinkHere) 

      - Screenshots

        - Use ![image](Hello) format.

        - Describe what's on the image.

    - [ ] (mm/dd/yyyy of completion) Site should have basic styles/theme applied; everything should be styled

      - List of Evidence of Feature Completion
       
        - Navbar in local env
   
          ![Local Env](Styles/navbar_local.png)

        - Status: (In progress)

        - [Link to file](https://github.com/cjdomacena/IT202-003/blob/Milestone1/partials/nav.php)

      - Pull Request/s

        - [Navbar / PR #39](https://github.com/cjdomacena/IT202-003/pull/39/commits/2dbeddaee0bec252c154cc5f225ba135dc4381e3) 

      - Screenshots

        - Use ![image](Hello) format.

        - Describe what's on the image.

    - [ ] (mm/dd/yyyy of completion) Any output messages/errors should be “user friendly”

      - List of Evidence of Feature Completion

        - Status: (In progress, Incomplete, Pending)

        - Direct Link (Direct link to specific file)

      - Pull Request/s

        - [Pull Request #](insertLinkHere) 

      - Screenshots

        - Use ![image](Hello) format.

        - Describe what's on the image.

    - [ ] (mm/dd/yyyy of completion) User will be able to see their profile

      - List of Evidence of Feature Completion

        - Status: (In progress, Incomplete, Pending)

        - Direct Link (Direct link to specific file)
      
      - Pull Request/s

        - [Pull Request #](insertLinkHere) 

      - Screenshots

        - Use ![image](Hello) format.

        - Describe what's on the image.

    - [ ] (mm/dd/yyyy of completion) User will be able to edit their profile

      - List of Evidence of Feature Completion

        - Status: (In progress, Incomplete, Pending)

        - Direct Link (Direct link to specific file)

      - Pull Request/s

        - [Pull Request #](insertLinkHere) 

      - Screenshots

        - Use ![image](Hello) format.

        - Describe what's on the image.

</details>
  
- Milestone 2

- Milestone 3

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
  1. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
  2. Add, commit, push the related file changes to this branch
  3. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
     - Screenshot(s) of the site view (make sure they clearly show the feature)
     - Screenshot of the database data if applicable
     - Describe each screenshot to specify exactly what's being shown
     - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
  4. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)
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
