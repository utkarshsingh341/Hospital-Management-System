from keras.models import load_model
from keras.preprocessing import image
from keras.applications.vgg19 import preprocess_input
import numpy as np

model = load_model('pnuemonia-detector\model_vgg19.h5')
img = image.load_img('pnuemonia/image.jpg', target_size=(224, 224))
x = image.img_to_array(img)
x = np.expand_dims(x, axis=0)
img_data = preprocess_input(x)
classes = model.predict(img_data)

x = classes[0]
if(x[0] == 1):
    print("\nThe person whose Lung X-ray was uploaded is Normal\n")
else:
    print("\nThe person whose Lung X-ray was uploaded has pneumonia\n")
