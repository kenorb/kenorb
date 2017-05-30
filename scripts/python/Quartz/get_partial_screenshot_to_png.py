#!/usr/bin/python
# Gets partial screenshot and saves it into PNG file.
import Quartz.CoreGraphics as cg
region = cg.CGRectMake(0, 0, 400, 400) # You can also use cg.CGRectInfinite for the full screen.
image = cg.CGWindowListCreateImage(region, cg.kCGWindowListOptionOnScreenOnly, cg.kCGNullWindowID, cg.kCGWindowImageDefault)
prov = cg.CGImageGetDataProvider(image)
img_data = cg.CGDataProviderCopyData(prov)
img_width, img_height = cg.CGImageGetWidth(image), cg.CGImageGetHeight(image)

from pngcanvas import PNGCanvas
import struct
canvas = PNGCanvas(img_width, img_height)
for x in range(img_width):
    for y in range(img_height):
        # Calculate offset, based on http://www.markj.net/iphone-uiimage-pixel-color/
        offset = 4 * ((img_width * int(round(y))) + int(round(x)))
        # Pixel data is unsigned char (8bit unsigned integer), and there are for (blue,green,red,alpha).
        # Unpack data from string into Python'y integers.
        b, g, r, a = struct.unpack_from("BBBB", img_data, offset=offset)
		# Assign BGRA color as RGBA.
        canvas.point(x, y, color = (r, g, b, a))

with open("test.png", "wb") as f:
    f.write(canvas.dump())
