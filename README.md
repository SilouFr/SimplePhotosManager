# SimplePhotosManager

The Simple Photos Manager is made to share your photos easily and without database.
The code is very light and relies on the FancyBox library.

The internal structure is the following:
```
├───css
├───fancybox
│   ├───dist
│   ├───docs
│   └───src
│       ├───css
│       └───js
└───photos
    └───<level 1>
        └───<level 2>
            └───<level 3>
```

The following is an example of how I use the levels:
- the level 1 is made for a specific year
- the level 2 is made for an event
- the level 3 is made for a person or a date

Feel free to make your it your own way !

Then place the photos in the 3rd level folder. They must be jpg or png extensions.
Finally, navigate on the website's folder in or order to make php process the thumbs. You can also run php in command line for processing.
Huge number of photos may take some time to process them all, and will consume processor power. Be patient.

Bonus: if a zip or rar file is present in the folder, a link to download this file will appear.