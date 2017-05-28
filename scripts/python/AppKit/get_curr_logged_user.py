#!/usr/bin/python
# Prints the user name of the current console user.
# (from the System Configuration framework)
# Note: If the current console user is "loginwindow", treat that as equivalent to None.
from AppKit import NSWorkspace, NSBundle
from SystemConfiguration import SCDynamicStoreCopyConsoleUser
username = (SCDynamicStoreCopyConsoleUser(None, None, None) or [None])[0]
username = [username,""][username in [u"loginwindow", None, u""]]

if username:
  print(username)
