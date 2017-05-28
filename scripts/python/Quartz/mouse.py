#!/usr/bin/python
# Script simulating mouse events in macOS.
# See: https://stackoverflow.com/q/281133/55075
import sys
from AppKit import NSEvent
import Quartz

class Mouse():
    down = [Quartz.kCGEventLeftMouseDown, Quartz.kCGEventRightMouseDown, Quartz.kCGEventOtherMouseDown]
    up = [Quartz.kCGEventLeftMouseUp, Quartz.kCGEventRightMouseUp, Quartz.kCGEventOtherMouseUp]
    [LEFT, RIGHT, OTHER] = [0, 1, 2]

    def position(self):
        point = Quartz.CGEventGetLocation( Quartz.CGEventCreate(None) )
        return point.x, point.y

    def location(self):
        loc = NSEvent.mouseLocation()
        return loc.x, Quartz.CGDisplayPixelsHigh(0) - loc.y

    def move_to(self, x, y):
        moveEvent = Quartz.CGEventCreateMouseEvent(None, Quartz.kCGEventMouseMoved, (x, y), 0)
        Quartz.CGEventPost(Quartz.kCGHIDEventTap, moveEvent)

    def press(self, x, y, button=1):
        event = Quartz.CGEventCreateMouseEvent(None, Mouse.down[button], (x, y), button - 1)
        Quartz.CGEventPost(Quartz.kCGHIDEventTap, event)

    def release(self, x, y, button=1):
        event = Quartz.CGEventCreateMouseEvent(None, Mouse.up[button], (x, y), button - 1)
        Quartz.CGEventPost(Quartz.kCGHIDEventTap, event)

    def click(self, button=1):
        x, y = self.position()
        self.press(x, y, button)
        self.release(x, y, button)

    def click_pos(self, x, y, button=LEFT):
        self.move_to(x, y)
        self.click(button)

    def to_relative(self, x, y):
        curr_pos = Quartz.CGEventGetLocation( Quartz.CGEventCreate(None) )
        x += current_position.x;
        y += current_position.y;
        return [x, y]

    def move_rel(self, x, y):
        [x, y] = to_relative(x, y)
        moveEvent = Quartz.CGEventCreateMouseEvent(None, Quartz.kCGEventMouseMoved, Quartz.CGPointMake(x, y), 0)
        Quartz.CGEventPost(Quartz.kCGHIDEventTap, moveEvent)

# DEMO
if __name__ == '__main__':
    mouse = Mouse()
    if sys.platform == "darwin":
        print("Current mouse position: %d:%d" % mouse.position())
        print("Moving to 100:100...");
        mouse.move_to(100, 100)
        print("Clicking 200:200 position using the right mouse button...");
        mouse.click_pos(200, 200, mouse.RIGHT)
    elif sys.platform == "win32":
        print("Error: Platform not supported!")

