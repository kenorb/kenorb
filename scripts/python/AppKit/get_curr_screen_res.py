#!/usr/bin/python
# Prints current screen resolution.
# See: https://stackoverflow.com/q/1281397/55075
from AppKit import NSScreen
print("Current screen resolution: %dx%d" % (NSScreen.mainScreen().frame().size.width, NSScreen.mainScreen().frame().size.height))
