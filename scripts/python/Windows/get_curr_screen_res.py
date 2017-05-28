#!/usr/bin/env python
# Prints current screen resolution.
# See: https://stackoverflow.com/q/1281397/55075
from win32api import GetSystemMetrics
width = GetSystemMetrics [0]
height = GetSystemMetrics [1]
print("Current screen resolution: %dx%d" % (width, height))
