#!/usr/bin/python
# Prints a list of running apps.
from AppKit import NSWorkspace
workspace = NSWorkspace.sharedWorkspace()
for app in workspace.runningApplications():
  print(app.localizedName())
