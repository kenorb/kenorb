#!/usr/bin/env python
# Prints current screen resolution.
# See: https://stackoverflow.com/q/1281397/55075
import pygame
from pygame.locals import *

pygame.init()
screen = pygame.display.set_mode((640,480), FULLSCREEN)
x, y = screen.get_size()
print("Current screen resolution: %dx%d" % (x, y))
