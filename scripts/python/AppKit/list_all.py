#!/usr/bin/python

import Quartz
import time
from Quartz import CGWindowListCopyWindowInfo, kCGWindowListExcludeDesktopElements, kCGNullWindowID
from Foundation import NSSet, NSMutableSet

def windowList(wl):
    for v in wl:
        print ( 
        str(v.valueForKey_('kCGWindowOwnerPID') or '?').rjust(7) + 
            ' ' + str(v.valueForKey_('kCGWindowNumber') or '?').rjust(5) + 
            ' {' + ('' if v.valueForKey_('kCGWindowBounds') is None else ( 
                    str(int(v.valueForKey_('kCGWindowBounds').valueForKey_('X')))     + ',' + 
                    str(int(v.valueForKey_('kCGWindowBounds').valueForKey_('Y')))     + ',' + 
                    str(int(v.valueForKey_('kCGWindowBounds').valueForKey_('Width'))) + ',' + 
                    str(int(v.valueForKey_('kCGWindowBounds').valueForKey_('Height'))) 
                ) ).ljust(21) + '}' + 
            '\t[' + ((v.valueForKey_('kCGWindowOwnerName') or '') + ']') + 
            ('' if v.valueForKey_('kCGWindowName') is None else (' ' + 
            v.valueForKey_('kCGWindowName') or '')) 
        ).encode('utf8')

wl1 = CGWindowListCopyWindowInfo(kCGWindowListExcludeDesktopElements, kCGNullWindowID)
print('Move target window (or ignore)\n')
time.sleep(5)

print('PID'.rjust(7) + ' ' + 'WinID'.rjust(5) + '  ' + 'x,y,w,h'.ljust(21) + ' ' + '\t[Title] SubTitle')
print('-'.rjust(7,'-') + ' ' + '-'.rjust(5,'-') + '  ' + '-'.ljust(21,'-') + ' ' + '\t-------------------------------------------')

wl2 = CGWindowListCopyWindowInfo(kCGWindowListExcludeDesktopElements, kCGNullWindowID)

w = NSMutableSet.setWithArray_(wl1)
w.minusSet_(NSSet.setWithArray_(wl2))

wl = Quartz.CGWindowListCopyWindowInfo( Quartz.kCGWindowListOptionAll, Quartz.kCGNullWindowID)
wl = sorted(wl, key=lambda k: k.valueForKey_('kCGWindowOwnerPID'))

windowList(wl)

print('\nDetailed window information: {0}\n'.format(w))
