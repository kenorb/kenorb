#!/usr/bin/python
# Prints current window focus.
# See: https://apple.stackexchange.com/q/169277/22781
from AppKit import NSWorkspace
import time
workspace = NSWorkspace.sharedWorkspace()
active_app = workspace.activeApplication()['NSApplicationName']
print('Active focus: ' + active_app)
while True:
    time.sleep(1)
    prev_app = active_app
    active_app = workspace.activeApplication()['NSApplicationName']
    if prev_app != active_app:
        print('Focus changed to: ' + active_app)
