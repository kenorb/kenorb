#!/usr/bin/python
# Prints current active window.
# See: https://stackoverflow.com/q/373020/55075
from AppKit import NSWorkspace
active_app_name = NSWorkspace.sharedWorkspace().frontmostApplication().localizedName()
print(active_app_name)
