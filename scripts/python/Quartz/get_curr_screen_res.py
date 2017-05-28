#!/usr/bin/python
# Prints current screen resolution.
# See: https://stackoverflow.com/q/1281397/55075
from Quartz import CGDisplayBounds
from Quartz import CGMainDisplayID
display = CGDisplayBounds(CGMainDisplayID())
print("Current screen resolution: %dx%d" % (display.size.width, display.size.height))
