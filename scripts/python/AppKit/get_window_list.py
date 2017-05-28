#!/usr/bin/python
# Prints list of windows in the current workspace.
# See: https://stackoverflow.com/q/373020/55075
import sys
if sys.platform == "darwin":
	from AppKit import NSWorkspace
	from Quartz import (
		CGWindowListCopyWindowInfo,
		kCGWindowListOptionOnScreenOnly,
		kCGNullWindowID
	)

if sys.platform == "darwin":
	curr_app = NSWorkspace.sharedWorkspace().frontmostApplication()
	curr_app_name = curr_app.localizedName()
	options = kCGWindowListOptionOnScreenOnly
	windowList = CGWindowListCopyWindowInfo(options, kCGNullWindowID)
	for window in windowList:
		windowNumber = window['kCGWindowNumber']
		ownerName = window['kCGWindowOwnerName']
		geometry = window['kCGWindowBounds']
		windowTitle = window.get('kCGWindowName', u'Unknown')
		print("%s - %s (ID: %d): %s" % (ownerName, windowTitle.encode('ascii','ignore'), windowNumber, geometry))
elif sys.platform == "win32":
	(active_app_name, windowTitle) = _getActiveInfo_Win32()
