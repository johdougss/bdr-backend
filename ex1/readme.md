## (1) DEVELOPING A NEW TOOL (Web service/API only. No user interface needed.)

### User Stories
**1) As a guest user, I want to see the items of my TO DO list, so that I can see what tasks I need to work on.**

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to get the list of all existing tasks.
* The user must be able to get the details of a task.
* In case there is no task, the API must return the following message: "Wow. You have nothing else to do. Enjoy the rest of your day!".

**2) As a guest user, I want to add a new item into my TO DO list, so that I can store my tasks.**

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The system must not allow empty tasks. If that happens, then the API must return the following message: "Bad move! Try removing the task instead of deleting its content.".
* The system must set the date in which the item was created automatically.
* UUID must be automatically generated and it must be unique.
* The task Type must only allow "shopping" or "work". If another type is passed, then the API must return the following message: "The task type you provided is not supported. You can only use shopping or work.".

**3) As a guest user, I want to delete a task from my TO DO list, so that I can discard the tasks that I will no longer need to do.**

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to delete an existing task.
* If the task isn't valid anymore, the API must return the following message: "Good news! The task you were trying to delete didn't even exist.".

**4) As a guest user, I want to prioritize the tasks of my TO DO list, so that I can organize my work and always deliver the most valuable things first.**

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to edit the information of an existing task.
* If the task doesn't exist, then the API must return the following message: "Are you a hacker or something? The task you were trying to edit doesn't exist.".

**5) As a guest user, I want to prioritize the tasks of my TO DO list, so that I can organize my work and always deliver the most valuable things first.**

**ACCEPTANCE CRITERIA:**
* The API must be developed using REST concepts and practices.
* The user must be able to reorder the list based on his prioritization criteria.
* If the task shares the same priority of another existing task, the the system must be smart enough to reorder the entire list and prevent priority conflicts.

### EXTRA INFORMATION
**Entity**
```
{
      "uuid": "",
      "type": "",
      "content": "",
      "sort_order" : 0,
      "done" : true|false,
      "date_created": ""
   }
```
