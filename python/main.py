# import fingerprint_enhancer
# import os
# import cv2
# import sys

# n = len(sys.argv)

# if n != 2:
#     exit(1)

# folder = sys.argv[1]

# directory = os.path.join("./storage/app/public/extracted_files",folder)

# dirs = os.listdir(directory)

# for dir in dirs:
#     # try:
#     files = os.listdir(os.path.join(directory,dir))



#     for file in files:
#         file_path = os.path.join(directory,dir,file)
#         # raise Exception(file_path)
#         img = cv2.imread(file_path, 0)

#         # Enhance the fingerprint image
#         out = fingerprint_enhancer.enhance_Fingerprint(img)
#         out = fingerprint_enhancer.enhance_Fingerprint(out)
#         out = fingerprint_enhancer.enhance_Fingerprint(out)
#         # out = fingerprint_enhancer.enhance_Fingerprint(out)
#         # out = fingerprint_enhancer.enhance_Fingerprint(out)
#         # out = fingerprint_enhancer.enhance_Fingerprint(out)


#         # Invert the output
#         inverted_out = 255 - out

#         # Update the original file with the inverted enhanced image
#         cv2.imwrite(file_path, inverted_out)

#     # except:
#     #     pass

# exit(0)




import fingerprint_enhancer
import os
import cv2
import sys
from multiprocessing import Pool, cpu_count

def process_file(file_path):
    img = cv2.imread(file_path, 0)

    # Enhance the fingerprint image
    print(file_path)
    out = fingerprint_enhancer.enhance_Fingerprint(img)
    # out = fingerprint_enhancer.enhance_Fingerprint(out)
    # out = fingerprint_enhancer.enhance_Fingerprint(out)

    # Invert the output
    inverted_out = 255 - out

    # Update the original file with the inverted enhanced image
    cv2.imwrite(file_path, inverted_out)

def process_directory(dir_path):
    files = os.listdir(dir_path)
    for file in files:
        file_path = os.path.join(dir_path, file)
        process_file(file_path)

def main():
    if len(sys.argv) != 2:
        exit(1)

    folder = sys.argv[1]
    directory = os.path.join("./storage/app/public/extracted_files", folder)
    dirs = [os.path.join(directory, dir) for dir in os.listdir(directory)]

    # Use multiprocessing.Pool to process directories in parallel
    with Pool(cpu_count()) as pool:
        pool.map(process_directory, dirs)

main()
