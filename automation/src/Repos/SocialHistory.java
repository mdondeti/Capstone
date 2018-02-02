package Repos;


import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;

public class SocialHistory  {
	

		//non smoke 
		
		public static WebElement NonSmokeTobaccoYes (WebDriver driver) {
			return driver.findElement(By.id("non_smoke_tobacco_yes"));
		}
			
		
		public static WebElement NonSmokeTobaccoNo (WebDriver driver) {
			return driver.findElement(By.id("non_smoke_tobacco_yes"));
		}
		
		public static WebElement NonSmokeComment (WebDriver driver) {
			return driver.findElement(By.id("non_smoke_tobacco_comment"));
		}
		//smoke
		
		public static WebElement SmokeTobaccoYes (WebDriver driver) {
			return driver.findElement(By.id("smoke_tobacco_yes"));
		}
			
		
		public static WebElement SmokeTobaccoNo (WebDriver driver) {
			return driver.findElement(By.id("smoke_tobacco_yes"));
		}
		
		public static WebElement SmokeComment (WebDriver driver) {
			return driver.findElement(By.id("smoke_tobacco_comment"));
		}
		
		//alcohol yes
		public static WebElement YesAlcohol (WebDriver driver) {
			return driver.findElement(By.id("alcohol_yes"));
		}
		//alcohol no
		public static WebElement NoAlcohol (WebDriver driver) {
			return driver.findElement(By.id("alcohol_no"));
		}
		
		//sexually active
		public static WebElement SexuallyNonActive (WebDriver driver) {
			return driver.findElement(By.id("sexual_activity_not_active"));
		}
		
		public static WebElement SexuallyActive (WebDriver driver) {
			return driver.findElement(By.id("sexual_activity_active"));
		}
		
		public static WebElement SexuallyActiveComment (WebDriver driver) {
			return driver.findElement(By.id("Sexual_activity_comment"));
		}
		//
		public static WebElement SocialHistoryComment (WebDriver driver) {
			return driver.findElement(By.id("Sexual_activity_comment"));
		}
		//save
		public static WebElement SaveSocialHistory (WebDriver driver) {
			return driver.findElement(By.id("btn_save_social_history"));
		}
		
		//clear comment
		
		public static WebElement clearSocialComment (WebDriver driver) {
			return driver.findElement(By.id("btn_clear"));
		}
		

}