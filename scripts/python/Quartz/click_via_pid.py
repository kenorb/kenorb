#!/usr/bin/python
import sys
import objc
if sys.platform == "darwin":
    import Quartz
    from AppKit import NSWorkspace
    from Quartz import (
        CGWindowListCopyWindowInfo,
        kCGWindowListOptionOnScreenOnly,
        kCGNullWindowID
    )

mouseDown = [Quartz.kCGEventLeftMouseDown, Quartz.kCGEventRightMouseDown, Quartz.kCGEventOtherMouseDown]
mouseUp = [Quartz.kCGEventLeftMouseUp, Quartz.kCGEventRightMouseUp, Quartz.kCGEventOtherMouseUp]
[LEFT, RIGHT, OTHER] = [0, 1, 2]

# Get process ID based on its name (owner or title name).
def get_pid_by_name(name):
    pids = []
    for window in CGWindowListCopyWindowInfo(kCGWindowListOptionOnScreenOnly, kCGNullWindowID):
        pid = window['kCGWindowOwnerPID']
        ownerName = window['kCGWindowOwnerName']
        windowNumber = window['kCGWindowNumber']
        windowTitle = window.get('kCGWindowName', u'Unknown')
        geometry = window['kCGWindowBounds']
        if name in ownerName or name in windowTitle:
            pids.append(pid)
        pids = list(set(pids))
    return pids

# Send click even to the app via its PID.
def click_via_pid(pid, x, y, button=LEFT):
    pressEvent = Quartz.CGEventCreateMouseEvent(None, mouseUp[button], (x, y), button - 1)
    releaseEvent = Quartz.CGEventCreateMouseEvent(None, mouseDown[button], (x, y), button - 1)
    #Quartz.CGEventPostToPid(pid, pressEvent)
    #Quartz.CGEventPostToPid(pid, releaseEvent)

def click(x, y, button=LEFT):
    pressEvent = Quartz.CGEventCreateMouseEvent(None, mouseUp[button], (x, y), button - 1)
    releaseEvent = Quartz.CGEventCreateMouseEvent(None, mouseDown[button], (x, y), button - 1)
    Quartz.CGEventPost(Quartz.kCGHIDEventTap, pressEvent)
    Quartz.CGEventPost(Quartz.kCGHIDEventTap, releaseEvent)

def key_by_pid(pid, key):
    # @todo
    #keyDown = Quartz.CGEventCreateKeyboardEvent(None)
    #keyUp = Quartz.CGEventCreateKeyboardEvent(None)
    Quartz.CGEventPostToPid(pid, keyDown)
    Quartz.CGEventPostToPid(pid, keyUp)

if __name__ == '__main__':
    if sys.platform == "darwin":
        for pid in get_pid_by_name("Chrome"):
            #click_via_pid(pid, 100, 100)
            click(100, 100)
    elif sys.platform == "win32":
        print("Platform not supported!")

