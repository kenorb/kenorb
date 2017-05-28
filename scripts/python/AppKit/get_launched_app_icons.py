#!/usr/bin/python
# Prints a list of running apps and their icons.
from AppKit import NSWorkspace
workspace = NSWorkspace.sharedWorkspace()
for app in workspace.launchedApplications():
    appName = str(app.allValues()[-1])
    appPath = str(app.allValues()[0])
    appIcon = workspace.iconForFile_(appPath)
    icoPath = './' + appName + '.png'
    print(appName, appPath, icoPath)
    # appIcon.TIFFRepresentation().writeToFile_atomically_(icoPath, False) # Save to file.
