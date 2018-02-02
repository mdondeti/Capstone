package Tests;

import java.util.concurrent.TimeUnit;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;

public class BaseTest {
	
	protected WebDriver driver;
	
	public BaseTest() {
		System.setProperty("webdriver.gecko.driver","C:\\Users\\astri\\Desktop\\geckodriver.exe");
		driver = new FirefoxDriver();
		
		//driver.manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
		
		//Maximize the window
		System.out.println("got here");
		//driver.get("http://localhost/wechart/public/");
		driver.manage().window().maximize();
	}	

}
