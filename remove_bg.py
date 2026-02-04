from PIL import Image

def remove_green_background(image_path, output_path, lower_threshold=50):
    img = Image.open(image_path).convert("RGBA")
    datas = img.getdata()

    newData = []
    for item in datas:
        # Green is item[1], Red is item[0], Blue is item[2]
        # Heuristic: Green channel is significantly higher than Red and Blue
        # and Green channel is bright enough
        if item[1] > item[0] + lower_threshold and item[1] > item[2] + lower_threshold and item[1] > 100:
            newData.append((255, 255, 255, 0)) # Make Transparent
        else:
            newData.append(item)

    img.putdata(newData)
    img.save(output_path, "PNG")
    print(f"Saved transparent image to {output_path}")

if __name__ == "__main__":
    input_file = "/home/ekhool-237/.gemini/antigravity/brain/e4741c13-a79f-4d33-9b77-8701fa9e4f3b/big_data_green_screen_1770188814945.png"
    output_file = "/var/www/html/zeyobron.com/upload/zeyobron_plus_hero_transparent.png"
    
    remove_green_background(input_file, output_file)
