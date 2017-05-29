#!/usr/bin/python
# Prints list of all windows.
# Including all windows that are currently on all screens, excluding elements of the desktop.
# Docs: https://developer.apple.com/library/content/releasenotes/General/APIDiffsMacOSX10_8/CoreGraphics.html
# See: https://stackoverflow.com/q/44232433/55075
import Quartz
for window in Quartz.CGWindowListCopyWindowInfo(Quartz.kCGWindowListOptionOnScreenOnly & Quartz.kCGWindowListExcludeDesktopElements, Quartz.kCGNullWindowID):
    print("%s - %s" % (window['kCGWindowOwnerName'], window.get('kCGWindowName', u'Unknown').encode('ascii','ignore')))
