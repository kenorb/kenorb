#!/usr/bin/python
# Script sending mouse event to the application in macOS.
import Quartz

downID = [Quartz.kCGEventLeftMouseDown, Quartz.kCGEventRightMouseDown, Quartz.kCGEventOtherMouseDown]
upID = [Quartz.kCGEventLeftMouseUp, Quartz.kCGEventRightMouseUp, Quartz.kCGEventOtherMouseUp]
[LEFT, RIGHT, OTHER] = [0, 1, 2]

x, y = Quartz.CGEventGetLocation( Quartz.CGEventCreate(None) )
button = RIGHT
pressEvent = Quartz.CGEventCreateMouseEvent(None, downID[button], Quartz.CGPointMake(x, y), 0)
releaseEvent = Quartz.CGEventCreateMouseEvent(None, upID[button], Quartz.CGPointMake(x, y), 0)

# Works.
Quartz.CGEventPost(Quartz.kCGHIDEventTap, pressEvent)
Quartz.CGEventPost(Quartz.kCGHIDEventTap, releaseEvent)

# Doesn't work.
app_name = 'Chrome'
for window in Quartz.CGWindowListCopyWindowInfo(Quartz.kCGWindowListOptionOnScreenOnly, Quartz.kCGNullWindowID):
    if app_name in window['kCGWindowOwnerName'] or app_name in window.get('kCGWindowName', u'Unknown'):
        pid = window['kCGWindowOwnerPID']
        title = window.get('kCGWindowName', u'Unknown')
        print("Sending click to %s (PID: %d)" % (window['kCGWindowOwnerName'], pid))
        Quartz.CGEventPostToPid(pid, pressEvent) # ERROR: AttributeError: CGEventPostToPid
        Quartz.CGEventPostToPid(pid, releaseEvent)
        break
