from keras.models import load_model
from keras.preprocessing import image
from keras.applications.resnet50 import preprocess_input
import numpy as np

model = load_model('model_resnet.h5')
img = image.load_img('Datasets/val/PNEUMONIA/person1950_bacteria_4881.jpeg',target_size=(224,224))
x = image.img_to_array(img)
x = np.expand_dims(x,axis=0)
img_data = preprocess_input(x)
classes = model.predict(img_data)

print("\n#########OUTPUT#########\n")
print("\nClass Array: ",classes)
x = classes[0]
if(x[0]==0):
    print("\nThe person is normal\n")
else:
    print("\nThe person has pneumonia\n")