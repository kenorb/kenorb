#!/usr/bin/python
# Copyright 2010 Google Inc.
# Licensed under the Apache License, Version 2.0
# http://www.apache.org/licenses/LICENSE-2.0
# Google's Python Class
# http://code.google.com/edu/languages/google-python-class/
#

import sys
import re
import os
import shutil
import commands

"""Copy Special exercise
"""

# Write functions and modify main() to call them
# +++your code here+++

# Returns a list of the absolute paths of the special files in the given directory.
def get_special_paths(path):
  paths = []
  for root, dirs, files in os.walk(path):
    for filename in files:
      filepath = os.path.join(root, os.path.abspath(filename))
      paths.append(filepath)
  special_file = re.compile(r'__\w+__')
  return [f for f in paths if re.search(special_file, f)]

# Given a list of paths, copies those files into the given directory.
def copy_to(paths, path):
  pass

# Given a list of paths, zip those files up into the given zipfile.
def zip_to(paths, zippath):
  pass

def main():
  # This basic command line argument parsing code is provided.
  # Add code to call your functions below.

  # Make a list of command line arguments, omitting the [0] element
  # which is the script itself.
  args = sys.argv[1:]
  if not args:
    print "usage: [--todir dir][--tozip zipfile] dir [dir ...]"
    sys.exit(1)

  # todir and tozip are either set from command line
  # or left as the empty string.
  # The args array is left just containing the dirs.
  todir = ''
  if args[0] == '--todir':
    try:
      todir = args[1]
    except IndexError:
      print "Please specify the destination directory!"
      sys.exit(1)
    del args[0:2]

  tozip = ''
  if args[0] == '--tozip':
    try:
      tozip = args[1]
    except IndexError:
      print "Please specify the zip filename!"
      sys.exit(1)
    del args[0:2]

  if len(args) == 0:
    print "Error: must specify one or more dirs!"
    sys.exit(1)

  # +++your code here+++
  if todir == '' and tozip == '':
    for arg in args:
      for path in get_special_paths(arg):
        print path
  elif todir != '':
        print('TODO: todir')
  elif tozip != '':
        print('TODO: tozip')

  # Call your functions
  
if __name__ == "__main__":
  main()

# vim: set ts=2 sts=2 et sw=2 ft=python:
